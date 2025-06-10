<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Session;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use App\Models\Absen;
use App\Models\DetailKelas;
use App\Models\DetailPresensi;
use Illuminate\Support\Facades\DB;
// use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Tfpdf\Fpdi;

class OrtuController extends Controller
{
    public function showProfile()
    {
        $siswa = Session::get('siswa');
        $profile = Siswa::where('id', $siswa->id)->with('detailKelas.kelas.matapelajaran')->first();
        // dd($profile);
        return view('ortu.profile-siswa', compact('profile'));
    }
    public function index()
    {

        $siswa = session('siswa');

        if (!$siswa) {
            $siswa = Siswa::first();
            session(['siswa' => $siswa]);
        }
        $ortu = $siswa;

        $detailKelasList = DetailKelas::where('siswa_id', $siswa->id)->with('kelas')->get();

        $histories = [];
        foreach ($detailKelasList as $detailKelas) {
            $kelas = $detailKelas->kelas;
            $totalSiswa = DetailKelas::where('kelas_id', $kelas->id)->count();

            $totalPertemuan = $detailKelas->absen()->count();
            $hadir = $detailKelas->absen()->where('status', 'hadir')->count();
            $kehadiran = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100) : 0;

            $histories[] = (object)[
                'kelas' => $kelas->nama,
                'tahun' => $kelas->tahun,
                'peringkat' => rand(1, $totalSiswa), // dummy
                'total_siswa' => $totalSiswa,
                'kehadiran' => $kehadiran,
            ];
        }

        // Rata-rata nilai
        $nilaiList = Nilai::whereHas('detailKelas', function ($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->get();

        $rataRata = $nilaiList->count() > 0
            ? round(($nilaiList->sum('nilai_uts') + $nilaiList->sum('nilai_uas')) / ($nilaiList->count() * 2), 2)
            : null;

        $peringkat = $this->getSiswaRanking($siswa->id);
        $kehadiran = $histories[0]->kehadiran ?? null;
        ($histories);
        return view('ortu.historyakademik-ortu', compact('ortu', 'rataRata', 'peringkat', 'kehadiran', 'histories'));
    }

    private function getKelasSiswa($studentId)
    {
        return DetailKelas::where('siswa_id', $studentId)
            ->with('kelas.matapelajaran')
            ->first();
    }

    private function getDetailPresensiSiswa($studentId)
    {
        $siswa = Session::get('siswa');
        $detailKelas = $this->getKelasSiswa($studentId);
        return DetailPresensi::whereHas('presensi', function ($query) use ($siswa, $detailKelas) {
            $query->whereHas('kelas', function ($kelasQuery) use ($siswa, $detailKelas) {
                $kelasQuery->whereHas('detailKelas', function ($detailKelasQuery) use ($siswa) {
                    $detailKelasQuery->where('siswa_id', $siswa->id);
                })
                    ->where('id', $detailKelas->kelas_id); // match kelas_id
            });
        })
            ->with('presensi')
            ->get();
    }

    private function getStatusCount()
    {
        $countAbsenceStatus = DetailPresensi::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        // dd($countAbsenceStatus);
        $statusCount = [
            'masuk' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0
        ];
        foreach ($countAbsenceStatus as $status) {
            $statusCount[$status->status] = $status->total;
        }
        // dd($statusCount);
        return $statusCount;
    }

    private function getSiswaRanking($studentId)
    {
        $students = Siswa::whereHas('detailKelas.nilai')
            ->with(['detailKelas' => function ($query) {
                $query->with('nilai');
            }])
            ->get();
        // dd($students);
        $ranked = $students->map(function ($siswa) {
            $nilaiList = $siswa->detailKelas->flatMap->nilai;

            $totalScore = $nilaiList->sum(function ($nilai) {
                $uts = $nilai->nilai_uts ?? 0;
                $uas = $nilai->nilai_uas ?? 0;
                return ($uts + $uas) / 2;
            });

            $count = $nilaiList->count();
            $average = $count > 0 ? $totalScore / $count : 0;

            return [
                'siswa_id' => $siswa->id,
                'average' => $average
            ];
        })->sortByDesc('average')->values();
        // dd($ranked);
        foreach ($ranked as $index => $student) {
            if ($student['siswa_id'] == $studentId) {
                return $index + 1;
            }
        }

        return null;
    }

    public function showPageNilai()
    {
        $siswa = Session::get('siswa');
        if (!$siswa) {
            return redirect('/ortu')->with('error', 'Siswa tidak ditemukan dalam sesi.');
        }
        $studentRanking = $this->getSiswaRanking($siswa->id);
        $detailKelas = $this->getKelasSiswa($siswa->id);
        $tahunAjaran = $detailKelas->kelas->tahun_ajaran;
        // Get all subjects related to the student's class
        $matapelajaran = MataPelajaran::whereHas('kelas.detailKelas', function ($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })
            ->select('id', 'nama_mapel', 'semester')
            ->get();
        $semester = $matapelajaran->first()->semester ?? 'N/A';
        // Get nilai related to the student
        $nilai = Nilai::whereHas('detailKelas', function ($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })
            ->select('matapelajaran_id', 'nilai_uts', 'nilai_uas')
            ->get();
        // Check if the student has any grades
        // dd($matapelajaran);
        return view('ortu.nilai-ortu', compact('matapelajaran', 'nilai', 'detailKelas', 'siswa', 'semester', 'tahunAjaran', 'studentRanking'));
    }

    public function showPageKehadiran()
    {
        $siswa = Session::get('siswa');

        if (!$siswa) {
            return redirect('/ortu')->with('error', 'Siswa tidak ditemukan dalam sesi.');
        }

        $detailKelas = $this->getKelasSiswa($siswa->id);
        $matapelajaran = $detailKelas->kelas->matapelajaran;
        $semester = $matapelajaran->first()->semester ?? 'N/A';
        $tahunAjaran = $detailKelas->kelas->tahun_ajaran;
        // Fetch the absence records of the student
        $absences = $this->getDetailPresensiSiswa($siswa->id);
        $statusCount = $this->getStatusCount();

        // dd($absences);
        return view('ortu.kehadiran-ortu', compact('absences', 'detailKelas', 'siswa', 'semester', 'tahunAjaran', 'statusCount'));
    }

    public function showRaport(){
        $siswa = Session::get('siswa');
        $detailKelas = $this->getKelasSiswa($siswa->id);

        $pdf = new Fpdi();
        $pdf->setSourceFile(storage_path('app/private/template_rapot.pdf'));

        // === Page 1 ===
        $pdf->AddPage('P', [215.9, 355.6]);
        $template1 = $pdf->importPage(1);
        $pdf->useTemplate($template1);

        $pdf->SetFont('Helvetica', '',11);
        $pdf->SetTextColor(0, 0, 0);
        // Example writing on page 1
        $pdf->SetXY(42, 70.5);
        $pdf->Write(0, ucwords($siswa->nama));
        $pdf->SetXY(42, 77);
        $pdf->Write(0, $siswa->nisn . ' / ' . $siswa->nis);
        $pdf->SetXY(42, 83.5);
        $pdf->Write(0, $detailKelas->kelas->nama_kelas);
        $pdf->SetXY(42, 90.5);
        $pdf->Write(0, $detailKelas->kelas->semester);
        $pdf->SetXY(42, 96);
        $pdf->Write(0, $detailKelas->kelas->tahun_ajaran);

        // === Page 2 ===
        $pdf->AddPage('P', [215.9, 355.6]);
        $template2 = $pdf->importPage(2);
        $pdf->useTemplate($template2);

        // You can also write something on page 2 if needed:
        // $pdf->SetXY(30, 50);
        // $pdf->Write(0, "Page 2 Data Here");

        $pdfContent = $pdf->Output('S'); // S = Return as string

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf');
    }
}
