<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AlQuranLearningCategory;
use App\Models\AlQuranLearningSubcategory;
use App\Models\AlQuranStudentAssessment;
use App\Models\DetailKelas;
use App\Models\Siswa;
use App\Models\Staff;
use App\Models\StaffAcces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAlQuranLearningController extends Controller
{
    /**
     * Display the main Al-Quran Assessment dashboard
     */
    public function index($kelasId, $subcategoryId)
    {
        // Filter only records with Al-Quran access and get kelas_id
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('akses_alquran_learning', 1)
            ->get();

        // If no specific Al-Quran access, fall back to any access
        $staff_al_quran_access = $staff->where('akses_alquran_learning', 1)->first();
        $kelas_id = $staff_al_quran_access ? $staff_al_quran_access->kelas_id : $staff->first()->kelas_id;

        // Get subcategories from staff access
        $subcategoryIds = [];
        foreach ($staff as $access) {
            if ($access->alQuranSubcategories && $access->alQuranSubcategories->count() > 0) {
                $subcategoryIds = array_merge(
                    $subcategoryIds,
                    $access->alQuranSubcategories->pluck('id')->toArray()
                );
            }
        }
        // Get unique subcategory IDs
        $subcategoryIds = array_unique($subcategoryIds);

        // Get categories with allowed subcategories
        $categories = AlQuranLearningCategory::whereHas('subcategories', function ($query) use ($subcategoryIds) {
            $query->whereIn('id', $subcategoryIds);
        })->with(['subcategories' => function ($query) use ($subcategoryIds) {
            $query->whereIn('id', $subcategoryIds);
        }])->get();

        // Get recent assessments
        $recentAssessments = AlQuranStudentAssessment::whereIn('subcategory_id', $subcategoryIds)
            ->with(['subcategory.category', 'siswa', 'staff'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $staff_acces = (object)[
            'akses_nilai' => $staff->where('kelas_id', $kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff->where('kelas_id', $kelas_id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $kelas_id,
            'akses_alquran_learning' => $staff->where('kelas_id', $kelas_id)->contains('akses_alquran_learning', 1) ? 1 : 0,
            'akses_extrakurikuler' => $staff->where('kelas_id', $kelas_id)->contains('akses_extrakurikuler', 1) ? 1 : 0,
            'akses_worship_character' => $staff->where('kelas_id', $kelas_id)->contains('akses_worship_character', 1) ? 1 : 0
        ];

        return view('staf.al-quran.index', compact('categories', 'recentAssessments', 'staff_acces'));
    }

    /**
     * Show the form for creating a new assessment
     */
    public function createAssessment()
    {
        // Filter only records with Al-Quran access and get kelas_id
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('akses_alquran_learning', 1)
            ->get();

        // If no specific Al-Quran access, fall back to any access
        $staff_al_quran_access = $staff->where('akses_alquran_learning', 1)->first();
        $kelas_id = $staff_al_quran_access ? $staff_al_quran_access->kelas_id : $staff->first()->kelas_id;

        $subcategoryIds = [];
        foreach ($staff as $access) {
            $subcategoryIds = array_merge(
                $subcategoryIds,
                $access->alQuranSubcategories->pluck('id')->toArray()
            );
        }

        $subcategories = AlQuranLearningSubcategory::whereIn('id', $subcategoryIds)
            ->with('category')
            ->get();

        // Get students from classes staff has access to
        $kelasIds = $staff->pluck('kelas_id')->unique()->toArray();
        $students = Siswa::whereHas('detailKelas', function ($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->get();

        $staff_acces = (object)[
            'akses_nilai' => $staff->where('kelas_id', $kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff->where('kelas_id', $kelas_id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $kelas_id,
            'akses_alquran_learning' => $staff->where('kelas_id', $kelas_id)->contains('akses_alquran_learning', 1) ? 1 : 0,
            'akses_extrakurikuler' => $staff->where('kelas_id', $kelas_id)->contains('akses_extrakurikuler', 1) ? 1 : 0,
            'akses_worship_character' => $staff->where('kelas_id', $kelas_id)->contains('akses_worship_character', 1) ? 1 : 0
        ];

        return view('staf.al-quran.create-assessment', compact('subcategories', 'students', 'staff_acces'));
    }

    /**
     * Store a newly created assessment directly from the create form
     */
    public function storeNewAssessment(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'subcategory_id' => 'required|exists:al_quran_learning_subcategories,id',
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string'
        ]);

        $staff = session('staff');

        // Check if staff has access to this subcategory
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_alquran_learning', 1)
            ->whereHas('alQuranSubcategories', function ($query) use ($request) {
                $query->where('al_quran_learning_subcategories.id', $request->subcategory_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk sub-kategori ini')
                ->withInput();
        }

        // Check if assessment already exists
        $existingAssessment = AlQuranStudentAssessment::where('subcategory_id', $request->subcategory_id)
            ->where('siswa_id', $request->siswa_id)
            ->first();

        if ($existingAssessment) {
            // Update existing assessment
            $existingAssessment->update([
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
                'staff_id' => $staff->id
            ]);

            return redirect()->route('staff.al-quran.index')
                ->with('success', 'Penilaian berhasil diperbarui');
        } else {
            // Create new assessment
            AlQuranStudentAssessment::create([
                'subcategory_id' => $request->subcategory_id,
                'siswa_id' => $request->siswa_id,
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
                'staff_id' => $staff->id
            ]);

            return redirect()->route('staff.al-quran.index')
                ->with('success', 'Penilaian berhasil disimpan');
        }
    }

    /**
     * Store or update an assessment
     */
    public function updateAssessment(Request $request, $subcategoryId, $siswaId)
    {
        $request->validate([
            'siswa_id' => 'required',
            'subcategory_id' => 'required',
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string|max:50'
        ]);

        // Check if staff has access to this subcategory
        $hasAccess = StaffAcces::where('staff_id', $request->created_by_id)
            ->where('akses_alquran_learning', 1)
            ->whereHas('alQuranSubcategories', function ($query) use ($subcategoryId) {
                $query->where('al_quran_learning_subcategories.id', $subcategoryId);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.al-quran.index')
                ->with('error', 'Anda tidak memiliki akses untuk subkategori ini');
        }

        // Create or update assessment
        AlQuranStudentAssessment::updateOrCreate(
            [
                'subcategory_id' => $subcategoryId,
                'siswa_id' => $siswaId,
            ],
            [
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'staff_id' => $request->created_by_id
            ]
        );

        return redirect()->route('staff.al-quran.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Delete an assessment
     */
    public function deleteAssessment($id)
    {
        $assessment = AlQuranStudentAssessment::findOrFail($id);
        $staff = session('staff');

        // Check if staff has access to this subcategory
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_alquran_learning', 1)
            ->whereHas('alQuranSubcategories', function ($query) use ($assessment) {
                $query->where('al_quran_learning_subcategories.id', $assessment->subcategory_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.al-quran.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus penilaian ini');
        }

        $subcategoryId = $assessment->subcategory_id;
        $assessment->delete();

        return redirect()->route('staff.al-quran.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }

    /**
     * Display assessments by subcategory
     */
    public function assessmentBySubcategory($kelasId, $subcategoryId)
    {
        // Verify staff access
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('kelas_id', $kelasId)
            ->where('akses_alquran_learning', 1)
            ->whereHas('alQuranSubcategories', function ($query) use ($subcategoryId) {
                $query->where('al_quran_learning_subcategories.id', $subcategoryId);
            })
            ->first();

        if (!$staff) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk subcategory ini');
        }

        $subcategory = AlQuranLearningSubcategory::with('category')->findOrFail($subcategoryId);

        // Get students in this class with their assessments for this subcategory
        $students = Siswa::whereHas('kelas', function ($query) use ($kelasId) {
            $query->where('kelas.id', $kelasId);
        })->with(['alQuranAssessments' => function ($query) use ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }])->get();

        // Get assessments for this subcategory and class
        $assessments = AlQuranStudentAssessment::where('subcategory_id', $subcategoryId)
            ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
                $query->where('kelas.id', $kelasId);
            })
            ->with(['siswa', 'subcategory.category'])
            ->latest()
            ->get();

        return view('staf.al-quran.assessment-by-subcategory', compact(
            'subcategory',
            'students',
            'assessments',
            'kelasId'
        ));
    }
}
