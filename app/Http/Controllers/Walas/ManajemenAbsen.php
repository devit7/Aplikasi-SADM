<?php

namespace App\Http\Controllers\Walas;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\DetailPresensi;
use App\Models\Kelas;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManajemenAbsen extends Controller
{
    public function index()
    {
        // Get the current wali kelas's class
        $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

        if (!$kelas) {
            dd('Anda belum memiliki kelas yang dikelola');
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Check if today's attendance already exists
        $tanggalHariIni = now()->format('Y-m-d');
        $presensiHariIni = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggalHariIni)
            ->first();

        // Get all presensi records for this class
        $presensi = Presensi::where('kelas_id', $kelas->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('walas.manajemen-absensi.index', compact('presensi', 'kelas', 'presensiHariIni'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value != now()->format('Y-m-d')) {
                        $fail('Tanggal absen hanya boleh untuk hari ini.');
                    }
                }
            ],
            'status' => 'required|in:hadir,izin,sakit,alpha',

        ]);

        $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Use today's date automatically
        $tanggalHariIni = now()->format('Y-m-d');

        // Check if presensi for today already exists
        $existingPresensi = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggalHariIni)
            ->first();

        if ($existingPresensi) {
            return redirect()->route('walas.manajemen-absen.show', $tanggalHariIni)
                ->with('info', 'Presensi untuk hari ini sudah ada, silakan lanjutkan mengisi absensi.');
        }

        // Create new presensi
        $presensi = Presensi::create([
            'tanggal' => $tanggalHariIni,
            'kelas_id' => $kelas->id,
            'status' => 'belum_diabsen',
        ]);

        // Get all students in this class
        $detailKelas = DetailKelas::where('kelas_id', $kelas->id)->get();

        // Create detail presensi for each student
        foreach ($detailKelas as $detail) {
            DetailPresensi::create([
                'presensi_id' => $presensi->id,
                'siswa_id' => $detail->siswa_id,
                'status' => 'masuk',
            ]);
        }

        return redirect()->route('walas.manajemen-absen.show', $tanggalHariIni)
            ->with('success', 'Presensi untuk hari ini berhasil dibuat!');
    }

    public function show($tanggal)
    {
        $user = Auth::user();
        $kelas = Kelas::where('walikelas_id', $user->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas yang dikelola');
        }

        // Get presensi for this date
        $presensi = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$presensi) {
            // Create new presensi for this date
            $presensi = Presensi::create([
                'tanggal' => $tanggal,
                'kelas_id' => $kelas->id,
                'status' => 'belum_diabsen',
            ]);

            // Get all students in this class
            $detailKelas = DetailKelas::where('kelas_id', $kelas->id)->get();

            // Create detail presensi for each student
            foreach ($detailKelas as $detail) {
                DetailPresensi::create([
                    'presensi_id' => $presensi->id,
                    'siswa_id' => $detail->siswa_id,
                    'status' => 'masuk',
                ]);
            }
        }

        // Get all detail presensi for this presensi
        $detailPresensi = DetailPresensi::with('siswa')
            ->where('presensi_id', $presensi->id)
            ->get();

        return view('walas.manajemen-absensi.show', compact('presensi', 'detailPresensi', 'tanggal'));
    }

    public function simpanPresensi(Request $request)
    {
        $request->validate([
            'presensi_id' => 'required|exists:presensis,id',
            'siswa_status' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $presensiId = $request->presensi_id;

            foreach ($request->siswa_status as $siswaId => $status) {
                DetailPresensi::where('presensi_id', $presensiId)
                    ->where('siswa_id', $siswaId)
                    ->update(['status' => $status]);
            }

            // Update presensi status to 'selesai'
            Presensi::where('id', $presensiId)->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->route('walas.manajemen-absen.index')
                ->with('success', 'Presensi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
