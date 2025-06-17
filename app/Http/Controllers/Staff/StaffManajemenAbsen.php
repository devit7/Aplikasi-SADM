<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\DetailPresensi;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\StaffAcces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffManajemenAbsen extends Controller
{
    /**
     * Get staff access data with proper authorization
     */
    private function getStaffAccessData()
    {
        $staff_acces_collection = StaffAcces::where('staff_id', session('staff')->id)->get();

        if ($staff_acces_collection->isEmpty()) {
            return null;
        }

        // Only allow if staff has explicit absen access
        $staff_absen_access = $staff_acces_collection->where('akses_absen', 1)->first();

        if (!$staff_absen_access) {
            return null; // No fallback - must have explicit absen access
        }

        $kelas_id = $staff_absen_access->kelas_id;
        $kelas = Kelas::find($kelas_id);

        if (!$kelas) {
            return null;
        }

        $staff_acces = (object)[
            'akses_nilai' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $kelas_id,
            'akses_alquran_learning' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_alquran_learning', 1) ? 1 : 0,
            'akses_extrakurikuler' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_extrakurikuler', 1) ? 1 : 0,
            'akses_worship_character' => $staff_acces_collection->where('kelas_id', $kelas_id)->contains('akses_worship_character', 1) ? 1 : 0
        ];

        return [
            'kelas' => $kelas,
            'staff_acces' => $staff_acces,
            'staff_acces_collection' => $staff_acces_collection
        ];
    }

    public function index()
    {
        $accessData = $this->getStaffAccessData();

        if (!$accessData) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengelola absensi kelas');
        }

        $kelas = $accessData['kelas'];
        $staff_acces = $accessData['staff_acces'];

        // Check if today's attendance already exists
        $tanggalHariIni = now()->format('Y-m-d');
        $presensiHariIni = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggalHariIni)
            ->first();

        $presensi = Presensi::where('kelas_id', $kelas->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('staf.manajemen-absensi.index', compact('presensi', 'kelas', 'presensiHariIni', 'staff_acces'));
    }

    public function store(Request $request)
    {
        // only what we actually use
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
        ]);

        $accessData = $this->getStaffAccessData();

        if (!$accessData) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengelola absensi kelas');
        }

        $kelas = $accessData['kelas'];

        // Verify the requested kelas_id matches staff's access
        if ($request->kelas_id != $kelas->id) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk kelas yang diminta');
        }

        // Use the validated date from request
        $tanggal = $request->tanggal;

        // Check if presensi for this date already exists
        $existingPresensi = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existingPresensi) {
            return redirect()->route('staff.manajemen-absen.show', $tanggal)
                ->with('info', 'Presensi untuk tanggal ini sudah ada, silakan lanjutkan mengisi absensi.');
        }

        DB::beginTransaction();
        try {
            // Create new presensi
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

            DB::commit();

            return redirect()->route('staff.manajemen-absen.show', $tanggal)
                ->with('success', 'Presensi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($tanggal)
    {
        $accessData = $this->getStaffAccessData();

        if (!$accessData) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengelola absensi kelas');
        }

        $kelas = $accessData['kelas'];
        $staff_acces = $accessData['staff_acces'];

        // Get presensi for this date
        $presensi = Presensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$presensi) {
            // Create new presensi for this date
            DB::beginTransaction();
            try {
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

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        // Get all detail presensi for this presensi
        $detailPresensi = DetailPresensi::with('siswa')
            ->where('presensi_id', $presensi->id)
            ->get();

        return view('staf.manajemen-absensi.show', compact('presensi', 'detailPresensi', 'tanggal', 'kelas', 'staff_acces'));
    }

    public function simpanPresensi(Request $request)
    {
        $request->validate([
            'presensi_id' => 'required|exists:presensis,id',
            'siswa_status' => 'required|array',
        ]);

        $accessData = $this->getStaffAccessData();

        if (!$accessData) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengelola absensi kelas');
        }

        // Verify presensi belongs to staff's class
        $presensi = Presensi::find($request->presensi_id);
        if ($presensi->kelas_id != $accessData['kelas']->id) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk presensi ini');
        }

        DB::beginTransaction();

        try {
            foreach ($request->siswa_status as $siswaId => $status) {
                DetailPresensi::where('presensi_id', $request->presensi_id)
                    ->where('siswa_id', $siswaId)
                    ->update(['status' => $status]);
            }

            // Update presensi status to 'selesai'
            $presensi->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->route('staff.manajemen-absen.index')
                ->with('success', 'Presensi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
