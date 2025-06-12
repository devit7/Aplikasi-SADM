<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ExtrakurikulerCategory;
use App\Models\ExtrakurikulerStudentAssessment;
use App\Models\Siswa;
use App\Models\StaffAcces;
use Illuminate\Http\Request;

class StaffExtrakurikulerController extends Controller
{
    /**
     * Display a listing of the Extrakurikuler categories
     */
    public function index($categoryId)
    {
        // Check if the staff has access to Extrakurikuler
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('akses_extrakurikuler', 1)
            ->whereHas('extrakurikulerCategories', function ($query) use ($categoryId) {
                $query->where('extrakurikuler_categories.id', $categoryId);
            })
            ->first();
        if (!$staff) {
            return redirect()->route('staff.dashboard')->with('error', 'Anda tidak memiliki akses untuk Extrakurikuler');
        }

        // Filter only records with Extrakurikuler access and get kelas_id
        // $staff_extrakurikuler_access = $staff->where('akses_extrakurikuler', 1)->first();
        // $kelas_id = $staff ? $staff_extrakurikuler_access->kelas_id : $staff->first()->kelas_id;

        // Get categories from staff access
        // $categoryIds = [];
        // foreach ($staff as $access) {
        //     if ($access->extrakurikulerCategories && $access->extrakurikulerCategories->count() > 0) {
        //         $categoryIds = array_merge(
        //             $categoryIds,
        //             $access->extrakurikulerCategories->pluck('id')->toArray()
        //         );
        //     }
        // }

        // // Get unique category IDs
        // $categoryIds = array_unique($categoryIds);

        // Get categories 
        $category = ExtrakurikulerCategory::findOrFail($categoryId);

        // Get recent assessments
        $recentAssessments = ExtrakurikulerStudentAssessment::where('category_id', $categoryId)
            ->whereHas('siswa.kelas', function ($query) use ($staff) {
                $query->where('kelas.id', $staff->kelas_id);
            })
            ->with(['siswa', 'category'])
            ->latest()
            ->get();

        // Get data for sub-categories if needed (similar to Al-Quran structure)
        $students = Siswa::whereHas('kelas', function ($query) use ($staff) {
            $query->where('kelas.id', $staff->kelas_id);
        })->with(['extrakurikulerAssessments' => function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        }])->get();

        $staff_acces = (object)[
            'akses_nilai' => $staff->where('kelas_id', $staff->kelas_id)->contains('akses_nilai', 1) ? 1 : 0,
            'akses_absen' => $staff->where('kelas_id', $staff->kelas_id)->contains('akses_absen', 1) ? 1 : 0,
            'kelas_id' => $staff->kelas_id,
            'akses_alquran_learning' => $staff->where('kelas_id', $staff->kelas_id)->contains('akses_alquran_learning', 1) ? 1 : 0,
            'akses_extrakurikuler' => $staff->where('kelas_id', $staff->kelas_id)->contains('akses_extrakurikuler', 1) ? 1 : 0,
            'akses_worship_character' => $staff->where('kelas_id', $staff->kelas_id)->contains('akses_worship_character', 1) ? 1 : 0
        ];

        return view('staf.extrakurikuler.index', compact('category', 'recentAssessments', 'staff_acces', 'students', 'kelas_id'));
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

        if ($staff->isEmpty()) {
            return redirect()->route('staff.dashboard')->with('error', 'Anda tidak memiliki akses untuk Extrakurikuler');
        }

        $categoryIds = [];
        foreach ($staff as $access) {
            if ($access->extrakurikulerCategories && $access->extrakurikulerCategories->count() > 0) {
                $categoryIds = array_merge(
                    $categoryIds,
                    $access->extrakurikulerCategories->pluck('id')->toArray()
                );
            }
        }

        $categories = ExtrakurikulerCategory::whereIn('id', $categoryIds)->get();

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

        return view('staf.extrakurikuler.create-assessment', compact('categories', 'students', 'staff_acces'));
    }

    /**
     * Store a newly created assessment
     */
    public function storeNewAssessment(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'category_id' => 'required|exists:extrakurikuler_categories,id',
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string'
        ]);

        $staff = session('staff');

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_extrakurikuler', true)
            ->whereHas('extrakurikulerCategories', function ($query) use ($request) {
                $query->where('extrakurikuler_categories.id', $request->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk kategori ini')
                ->withInput();
        }

        // Check if assessment already exists
        $existingAssessment = ExtrakurikulerStudentAssessment::where('category_id', $request->category_id)
            ->where('siswa_id', $request->siswa_id)
            ->first();

        if ($existingAssessment) {
            // Update existing assessment
            $existingAssessment->update([
                'category_id' => $request->category_id,
                'siswa_id' => $request->siswa_id,
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
            ]);

            return redirect()->route('staff.extrakurikuler.index')
                ->with('success', 'Penilaian berhasil diperbarui');
        } else {
            // Create new assessment
            ExtrakurikulerStudentAssessment::create([
                'category_id' => $request->category_id,
                'siswa_id' => $request->siswa_id,
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
            ]);

            return redirect()->route('staff.extrakurikuler.index')
                ->with('success', 'Penilaian berhasil disimpan');
        }
    }

    /**
     * Update an assessment via modal
     */
    public function updateAssessment(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'siswa_id' => 'required',
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string|max:50'
        ]);

        $staff = session('staff');
        $assessment = ExtrakurikulerStudentAssessment::findOrFail($id);

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_extrakurikuler', true)
            ->whereHas('extrakurikulerCategories', function ($query) use ($assessment) {
                $query->where('extrakurikuler_categories.id', $assessment->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.extrakurikuler.index')
                ->with('error', 'Anda tidak memiliki akses untuk kategori ini');
        }

        // Update assessment
        $assessment->update([
            'category_id' => $request->category_id,
            'siswa_id' => $request->siswa_id,
            'predicate' => $request->predicate,
            'explanation' => $request->explanation,
            'created_by' => $request->created_by
        ]);

        return redirect()->route('staff.extrakurikuler.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Delete an assessment
     */
    public function deleteAssessment($id)
    {
        $assessment = ExtrakurikulerStudentAssessment::findOrFail($id);
        $staff = session('staff');

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_extrakurikuler', true)
            ->whereHas('extrakurikulerCategories', function ($query) use ($assessment) {
                $query->where('extrakurikuler_categories.id', $assessment->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.extrakurikuler.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus penilaian ini');
        }

        $assessment->delete();

        return redirect()->route('staff.extrakurikuler.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }

    public function assessmentByCategory($kelasId, $categoryId)
    {
        // Verify staff access
        // $staff = StaffAcces::where('staff_id', session('staff')->id)
        //     ->where('kelas_id', $kelasId)
        //     ->where('akses_extrakurikuler', 1)
        //     ->whereHas('extrakurikulerCategories', function ($query) use ($categoryId) {
        //         $query->where('extrakurikuler_categories.id', $categoryId);
        //     })
        //     ->first();

        // if (!$staff) {
        //     return redirect()->route('staff.dashboard')
        //         ->with('error', 'Anda tidak memiliki akses untuk kategori ini');
        // }

        // $category = ExtrakurikulerCategory::findOrFail($categoryId);

        // Get students in this class with their assessments for this category
        // $students = Siswa::whereHas('kelas', function ($query) use ($kelasId) {
        //     $query->where('kelas.id', $kelasId);
        // })->with(['extrakurikulerAssessments' => function ($query) use ($categoryId) {
        //     $query->where('category_id', $categoryId);
        // }])->get();

        // Get assessments for this category and class
        // $assessments = ExtrakurikulerStudentAssessment::where('category_id', $categoryId)
        //     ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
        //         $query->where('kelas.id', $kelasId);
        //     })
        //     ->with(['siswa', 'category'])
        //     ->latest()
        //     ->get();

        // return view('staf.extrakurikuler.assessment-by-category', compact(
        //     'category',
        //     'students',
        //     'assessments',
        //     'kelasId'
        // ));
    }
}
