<?php

namespace App\Http\Controllers\Walas;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\Matapelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ManajemenNilai extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel_with_nilai = Matapelajaran::with('nilai')->get();
        $status_nilai = Nilai::with('matapelajaran')->where('nilai_uts', '!=', '0')->where('nilai_uas', '!=', '0')->count();
        // dd("mapel with nilai\n\n" . $mapel_with_nilai);

        return view('walas.manajemen-nilai.index', compact('mapel_with_nilai', 'status_nilai'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nilai = Nilai::where('matapelajaran_id', $id)->get();
        $siswa = Siswa::whereHas('detail_kelas', function($query) use ($id) {
            $query->whereHas('matapelajaran', function($q) use ($id) {
                $q->where('id', $id);
            });
        })->get();

        dd("show(): " . $nilai . "\nSiswa: " . $siswa);


        return view('walas.manajemen-nilai.show', compact('id'));
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
