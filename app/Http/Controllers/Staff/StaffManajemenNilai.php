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
        // Mengambil semua data staff yang memiliki akses kelas
        $staff_acces_collection = StaffAcces::where('staff_id', session('staff')->id)->get();

        $kelas = Kelas::whereIn('id', $staff_acces_collection->pluck('kelas_id'))->first();

        // Filter only records with nilai access and get kelas_id
        $staff_nilai_access = $staff_acces_collection->whereIn('kelas_id', $kelas->id)->first();

        // Membuat objek dengan absen & nilai akses berdasarkan semua record staff_acces
        $staff_acces = (object)[
            'akses_nilai' => $staff_acces_collection->where('kelas_id', $kelas->id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff_acces_collection->where('kelas_id', $kelas->id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $kelas->id
        ];


        // Filter mata pelajaran berdasarkan akses staff
        $mapel_with_nilai = Matapelajaran::with(['nilai' => function ($query) {
            $query->where('nilai_uts', '!=', '0')
                ->where('nilai_uas', '!=', '0');
        }])
            ->where('id', $staff_nilai_access->matapelajaran_id)
            ->get();

        // Transform data untuk mendapatkan status nilai per mata pelajaran
        $mapel_with_nilai = $mapel_with_nilai->map(function ($mapel) {
            $mapel->status_nilai = $mapel->nilai->count() > 0 ? 'Dinilai' : 'Belum Dinilai';
            return $mapel;
        });


        return view('staf.manajemen-nilai.index', compact('mapel_with_nilai', 'kelas', 'staff_acces'));
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

            // Get staff access information to pass back
            $staff_acces_collection = StaffAcces::where('staff_id', session('staff')->id)->get();

            // Filter only records with nilai access and get kelas_id
            $staff_nilai_access = $staff_acces_collection->where('akses_nilai', 1)->first();

            // If no specific nilai access, fall back to any access
            $kelas_id = $staff_nilai_access ? $staff_nilai_access->kelas_id : $staff_acces_collection->first()->kelas_id;

            // Create staff_acces object with the same structure as in other methods
            $staff_acces = (object)[
                'akses_nilai' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
                'akses_absen' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_absen', 1) ? 1 : 0,
                'kelas_id' => $kelas_id
            ];

            // Store staff_acces in session to ensure it's available after redirect
            session(['temp_staff_acces' => $staff_acces]);

            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        // Mengambil semua data staff yang memiliki akses kelas
        $staff_acces_collection = StaffAcces::where('staff_id', session('staff')->id)->get();

        // Jika tidak ada akses sama sekali
        if ($staff_acces_collection->isEmpty()) {
            return redirect()->back()->with('error', 'Anda belum memiliki akses kelas yang dikelola');
        }

        // Filter only records with nilai access and get kelas_id
        $staff_nilai_access = $staff_acces_collection->where('akses_nilai', 1)->first();

        // If no specific nilai access, fall back to any access
        $kelas_id = $staff_nilai_access ? $staff_nilai_access->kelas_id : $staff_acces_collection->first()->kelas_id;
        $kelas = Kelas::where('id', $kelas_id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Membuat objek dengan absen & nilai akses berdasarkan semua record staff_acces
        $staff_acces = (object)[
            'akses_nilai' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $kelas_id
        ];

        // Dapatkan daftar matapelajaran_id yang dimiliki staff
        $staff_mapel_ids = $staff_acces_collection
            ->where('staff_id', session('staff')->id)
            ->where('akses_nilai', 1)
            ->pluck('matapelajaran_id')
            ->toArray();

        // Periksa apakah staff memiliki akses ke mata pelajaran yang diminta
        if (!in_array($id, $staff_mapel_ids)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mata pelajaran ini');
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

        return view('staff.manajemen-nilai.show', compact('data', 'kelas', 'staff_acces'));
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
