<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Session;
use App\Models\Nilai;
use App\Models\Matapelajaran;
use App\Models\Absen;
use App\Models\AlQuranStudentAssessment;
use App\Models\DetailKelas;
use App\Models\DetailPresensi;
use App\Models\ExtrakurikulerStudentAssessment;
use App\Models\WorshipStudentAssessment;
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
        // dd($siswa);
        $detailPresensi = DetailPresensi::where('siswa_id', $siswa->id)
            ->whereHas('presensi', function ($presensiQuery) use ($siswa) {
                $presensiQuery->whereHas('kelas', function ($kelasQuery) use ($siswa) {
                    $kelasQuery->whereHas('detailKelas', function ($detailKelasQuery) use ($siswa) {
                        $detailKelasQuery->where('siswa_id', $siswa->id);
                    });
                });
            })
            ->with('presensi')
            ->get();
        // dd($detailPresensi);
        return $detailPresensi;
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

    private function getWorshipStudentAssessment($studentId)
    {
        return WorshipStudentAssessment::with('category')
            ->where('siswa_id', $studentId)
            ->get()
            ->groupBy('category.semester');
    }

    private function getExtrakurikulerStudentAssessment($studentId)
    {
        return ExtrakurikulerStudentAssessment::with('category')
            ->where('siswa_id', $studentId)
            ->get()
            ->groupBy('category.semester');
    }

    private function getAlQuranStudentAssessment($studentId)
    {
        return AlQuranStudentAssessment::with('subcategory.category')
            ->where('siswa_id', $studentId)
            ->get()
            ->groupBy('subcategory.semester');
    }

    private function getNilaiSiswaBySemester($studentId)
    {
        $student = Siswa::with([
            'detailKelas.nilai.mataPelajaran'
        ])->find($studentId);

        // Get all nilai for this student and group by semester
        $nilaiGrouped = $student->detailKelas
            ->flatMap(function ($detailKelas) {
                return $detailKelas->nilai->map(function ($nilai) {
                    // Add mata pelajaran name to each nilai object
                    $nilai->nama_mapel = $nilai->mataPelajaran->nama;
                    return $nilai;
                });
            })
            ->groupBy(function ($nilai) {
                return $nilai->mataPelajaran->semester;
            });

        $nilaiBySemester = [];
        foreach ($nilaiGrouped as $semester => $nilaiCollection) {
            $nilaiBySemester[$semester] = [];
            foreach ($nilaiCollection as $nilai) {
                $namaMapel = $nilai['mataPelajaran']['nama_mapel'] ?? '-';
                // dd($nilaiCollection, $semester ,$namaMapel);
                // Group by mata pelajaran name within each semester
                if (!isset($nilaiBySemester[$semester][$namaMapel])) {
                    $nilaiBySemester[$semester][$namaMapel] = [];
                }

                $nilaiBySemester[$semester][$namaMapel][] = [
                    'id' => $nilai->id,
                    'nilai' => ($nilai->nilai_uas + $nilai->nilai_uts) / 2,
                    'keterangan' => $nilai->keterangan ?? null,
                    'semester' => $semester,

                ];
            }
        }
        return $nilaiBySemester;
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
        $nilaiBySemester = $this->getNilaiSiswaBySemester($siswa->id);
        $statusCount = $this->getStatusCount();
        $quranLearning = $this->getAlQuranStudentAssessment($siswa->id);
        $extrakurikuler = $this->getExtrakurikulerStudentAssessment($siswa->id);
        $worship = $this->getWorshipStudentAssessment($siswa->id);
        // dd($worship);
        // dd($nilaiBySemester, $nilaiGrouped);
        return view('ortu.nilai-ortu', compact('matapelajaran', 'nilaiBySemester', 'detailKelas', 'siswa', 'semester', 'tahunAjaran', 'studentRanking', 'statusCount', 'quranLearning', 'extrakurikuler', 'worship'));
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
}
