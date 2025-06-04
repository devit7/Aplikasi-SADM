<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\StaffAcces;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $tahun_ajaran = Kelas::distinct()->pluck('tahun_ajaran');
        $semester = Matapelajaran::distinct()->pluck('semester');

        $staff_acces = StaffAcces::where('staff_id', session('staff')->id)->get();
        $kelas_ids = $staff_acces->pluck('kelas_id')->unique()->toArray(); // Ambil semua kelas_id dari staff_acces
        
        $kelas = Kelas::with('matapelajaran')
                    ->withCount('siswa')
                    ->whereIn('id', $kelas_ids)
                    ->get(); // Ambil semua kelas berdasarkan kelas_id yang ditemukan
        return view('staf.dashboard-staff', compact('kelas', 'tahun_ajaran', 'semester', 'staff_acces'));
    }

    public function show($id)   
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        $staff_acces_collection = StaffAcces::where('staff_id', session('staff')->id)->get();
        
        // Membuat objek dengan absen & nilai akses berdasarkan semua record staff_acces
        $staff_acces = (object)[
            'akses_nilai' => $staff_acces_collection->where('kelas_id', $id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff_acces_collection->where('kelas_id', $id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $id  // Tambahkan properti kelas_id
        ];
        
        return view('staf.list-siswa', compact('kelas', 'staff_acces'));
    }
}
