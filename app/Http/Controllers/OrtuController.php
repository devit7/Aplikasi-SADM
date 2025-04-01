<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Session;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use App\Models\Absen;
use App\Models\DetailKelas;

class ortuController extends Controller
{
    // Menampilkan halaman login ortu
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('siswa')) {
            return redirect('/ortu');
        }

        return view('ortu.login-ortu'); // Sesuaikan dengan nama view Anda
    }

    // Proses login ortu
    public function loginOrangTua(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|string',
            'nis' => 'required|string',
        ]);

        // Ambil data dari request
        $nisn = $request->input('nisn');
        $nis = $request->input('nis');

        // Cari siswa berdasarkan NISN dan NIS
        $siswa = Siswa::where('nisn', $nisn)
                      ->where('nis', $nis)
                      ->first();

        // Jika siswa ditemukan, simpan data ke session dan redirect ke dashboard
        if ($siswa) {
            // Simpan data siswa ke session
            Session::put('siswa', $siswa);

            return redirect('/ortu'); // Sesuaikan dengan route dashboard ortu
        }

        // Jika siswa tidak ditemukan, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'nisn' => 'NISN atau NIS yang Anda masukkan salah.',
        ])->withInput();
    }

    // Logout ortu
    public function logoutOrtu()
    {
        // Hapus session siswa
        Session::forget('siswa');

        return redirect('/ortu/login'); // Redirect ke halaman login
    }

    private function getKelasSiswa($studentId){
        return DetailKelas::where('siswa_id', $studentId)
        ->with('kelas.matapelajaran')
        ->first();
    }

    public function getNilai()
    {
        $siswa = Session::get('siswa');
        if (!$siswa) {
            return redirect('/ortu')->with('error', 'Siswa tidak ditemukan dalam sesi.');
        }

        $detailKelas = $this->getKelasSiswa($siswa->id);

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

        return view('ortu.nilai-ortu', compact('matapelajaran', 'nilai', 'detailKelas', 'siswa', 'semester'));
    }

    public function getAbsen()
    {
        $siswa = Session::get('siswa');

        if (!$siswa) {
            return redirect('/ortu')->with('error', 'Siswa tidak ditemukan dalam sesi.');
        }

        $detailKelas = $this->getKelasSiswa($siswa->id);
        $matapelajaran = $detailKelas->kelas->matapelajaran;
        $semester = $matapelajaran->first()->semester ?? 'N/A';

        // Fetch the absence records of the student
        $absences = Absen::whereHas('detailKelas', function ($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })
        ->with('detailKelas.kelas') // Load related class data
        ->select('detail_kelas_id', 'tanggal', 'status')
        ->orderBy('tanggal', 'desc')
        ->get();

        return view('ortu.kehadiran-ortu', compact('absences', 'detailKelas', 'siswa', 'semester'));
    }

}