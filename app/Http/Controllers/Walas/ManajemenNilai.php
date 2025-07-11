<?php

namespace App\Http\Controllers\Walas;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManajemenNilai extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the current role by wali kelas 
        /*  $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

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
        }); */
        // Get the current role by wali kelas 
        $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Filter mata pelajaran berdasarkan kelas wali kelas
        $mapel_with_nilai = Matapelajaran::with(['nilai'])
            ->where('kelas_id', $kelas->id) // Filter berdasarkan kelas
            ->get();

        // Transform data untuk mendapatkan status nilai per mata pelajaran
        $mapel_with_nilai = $mapel_with_nilai->map(function ($mapel) {
            $nilaiCount = $mapel->nilai->where('nilai_uts', '!=', '0')
                ->where('nilai_uas', '!=', '0')
                ->count();
            $mapel->status_nilai = $nilaiCount > 0 ? 'Dinilai' : 'Belum Dinilai';
            return $mapel;
        });

        return view('walas.manajemen-nilai.index', compact('mapel_with_nilai', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
            return redirect()->back()->with('errors', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the current role by wali kelas
        $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Get mata pelajaran dengan relasinya
        $nilai_siswa = Matapelajaran::with(['nilai.detailKelas.siswa', 'kelas.detailKelas.siswa'])
            ->where('id', $id)
            ->first();

        // Get semua siswa di kelas tersebut
        $siswas = $nilai_siswa->kelas->detailKelas->map(function ($detailKelas) {
            return $detailKelas->siswa;
        });

        // Restructure data
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

        return view('walas.manajemen-nilai.show', [
            'data' => $data,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
