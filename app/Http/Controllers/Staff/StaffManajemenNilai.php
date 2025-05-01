<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\StaffAcces;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffManajemenNilai extends Controller
{

    public function index()
    {
        // Get the current role by wali kelas 
        $staff_acces = StaffAcces::where('staff_id', session('staff')->id)->first();
        $kelas = Kelas::where('id', $staff_acces->kelas_id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        $mapel_with_nilai = Matapelajaran::with(['nilai' => function ($query) {
            $query->where('nilai_uts', '!=', '0')
                ->where('nilai_uas', '!=', '0');
        }])->get();

        // Transform data untuk mendapatkan status nilai per mata pelajaran
        $mapel_with_nilai = $mapel_with_nilai->map(function ($mapel) {
            $mapel->status_nilai = $mapel->nilai->count() > 0 ? 'Dinilai' : 'Belum Dinilai';
            return $mapel;
        });

        return view('staff.manajemen-nilai.index', compact('mapel_with_nilai', 'kelas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nama' => 'required|string',
                'id_mapel' => 'required|exists:matapelajaran,id',
                'id_kelas' => 'required|exists:kelas,id',
                'uts' => 'required|numeric|min:0|max:100',
                'uas' => 'required|numeric|min:0|max:100',
            ]);

            // Cari siswa dan detail kelas
            $siswa = Siswa::where('nama', $request->nama)->first();
            if (!$siswa) {
                return redirect()->back()->with('error', 'Siswa tidak ditemukan');
            }

            // Cari detail kelas yang aktif untuk siswa ini
            $detailKelas = DetailKelas::where('siswa_id', $siswa->id)
                ->where('kelas_id', $request->id_kelas)
                ->first();

            if (!$detailKelas) {
                return redirect()->back()->with('error', 'Data kelas siswa tidak ditemukan');
            }

            // Update atau create data nilai
            $nilai = Nilai::updateOrCreate(
                [
                    'detail_kelas_id' => $detailKelas->id,
                    'matapelajaran_id' => $request->id_mapel,
                ],
                [
                    'nilai_uts' => $request->uts,
                    'nilai_uas' => $request->uas,
                ]
            );

            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        // Mengambil data staff yang memiliki akses kelas yang dikelola
        $staff_acces = StaffAcces::where('staff_id', session('staff')->id)->first();
        $kelas = Kelas::where('id', $staff_acces->kelas_id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }
        
        // Get mata pelajaran dengan relasinya
        $nilai_siswa = Matapelajaran::with(['nilai.detailKelas.siswa', 'kelas.detailKelas.siswa'])
            ->where('id', $id)
            ->first();

        // mengambil semua siswa di kelas tersebut
        $siswas = $nilai_siswa->kelas->detailKelas->map(function ($detailKelas) {
            return $detailKelas->siswa;
        });

        //  membuat array untuk menyimpan data mata pelajaran dan siswa
        $mapelData = [
            'id' => $nilai_siswa->id,
            'nama_mapel' => $nilai_siswa->nama_mapel,
            'kelas' => $nilai_siswa->kelas,
            'nilai' => $nilai_siswa->nilai
        ];

        $data = [
            'mapel' => $mapelData,
            'siswa' => $siswas
        ];

        return view('staff.manajemen-nilai.show', compact('data', 'kelas'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
