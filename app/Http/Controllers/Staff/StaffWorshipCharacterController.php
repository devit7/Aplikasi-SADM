<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ExtrakurikulerCategory;
use App\Models\ExtrakurikulerStudentAssessment;
use App\Models\WorshipCharacterCategory;
use App\Models\WorshipStudentAssessment;
use App\Models\Siswa;
use App\Models\StaffAcces;
use Illuminate\Http\Request;

class StaffWorshipCharacterController extends Controller
{
    /**
     * Display a listing of the Worship & Character categories
     */
    public function index($kelasId, $subcategoryId)
    {
        // Check if the staff has access to Worship & Character
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('akses_worship_character', true)
            ->get();

        if ($staff->isEmpty()) {
            return redirect()->route('staff.dashboard')->with('error', 'Anda tidak memiliki akses untuk Worship & Character');
        }

        // Filter only records with Worship access and get kelas_id
        $staff_worship_access = $staff->where('akses_worship_character', 1)->first();
        $kelas_id = $staff_worship_access ? $staff_worship_access->kelas_id : $staff->first()->kelas_id;

        // Get categories from staff access
        $categoryIds = [];
        foreach ($staff as $access) {
            if ($access->worshipCategories && $access->worshipCategories->count() > 0) {
                $categoryIds = array_merge(
                    $categoryIds,
                    $access->worshipCategories->pluck('id')->toArray()
                );
            }
        }

        // Get unique category IDs
        $categoryIds = array_unique($categoryIds);

        // Get categories 
        $categories = WorshipCharacterCategory::whereIn('id', $categoryIds)->get();

        // Get recent assessments
        $recentAssessments = WorshipStudentAssessment::whereIn('category_id', $categoryIds)
            ->with(['category', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get students from the class that staff has access to
        $students = Siswa::whereHas('detailKelas', function ($query) use ($kelas_id) {
            $query->where('kelas_id', $kelas_id);
        })->get();

        $staff_acces = (object)[
            'akses_nilai' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_nilai == 1;
            })->count() > 0 ? 1 : 0,
            'akses_absen' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_absen == 1;
            })->count() > 0 ? 1 : 0,
            'kelas_id' => $kelas_id,
            'akses_alquran_learning' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_alquran_learning == 1;
            })->count() > 0 ? 1 : 0,
            'akses_extrakurikuler' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_extrakurikuler == 1;
            })->count() > 0 ? 1 : 0,
            'akses_worship_character' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_worship_character == 1;
            })->count() > 0 ? 1 : 0
        ];

        return view('staf.worship.index', compact('categories', 'recentAssessments', 'staff_acces', 'students'));
    }

    /**
     * Show the form for creating a new assessment
     */
    public function createAssessment()
    {
        // Filter only records with Worship access and get kelas_id
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('akses_worship_character', true)
            ->get();

        if ($staff->isEmpty()) {
            return redirect()->route('staff.dashboard')->with('error', 'Anda tidak memiliki akses untuk Worship & Character');
        }

        // Filter only records with Worship access and get kelas_id
        $staff_worship_access = $staff->where('akses_worship_character', 1)->first();
        $kelas_id = $staff_worship_access ? $staff_worship_access->kelas_id : $staff->first()->kelas_id;

        $categoryIds = [];
        foreach ($staff as $access) {
            if ($access->worshipCategories && $access->worshipCategories->count() > 0) {
                $categoryIds = array_merge(
                    $categoryIds,
                    $access->worshipCategories->pluck('id')->toArray()
                );
            }
        }

        $categories = WorshipCharacterCategory::whereIn('id', $categoryIds)->get();

        // Get students from classes staff has access to
        $kelasIds = $staff->pluck('kelas_id')->unique()->toArray();
        $students = Siswa::whereHas('detailKelas', function ($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->get();

        $staff_acces = (object)[
            'akses_nilai' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_nilai == 1;
            })->count() > 0 ? 1 : 0,
            'akses_absen' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_absen == 1;
            })->count() > 0 ? 1 : 0,
            'kelas_id' => $kelas_id,
            'akses_alquran_learning' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_alquran_learning == 1;
            })->count() > 0 ? 1 : 0,
            'akses_extrakurikuler' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_extrakurikuler == 1;
            })->count() > 0 ? 1 : 0,
            'akses_worship_character' => $staff->filter(function ($item) use ($kelas_id) {
                return $item->kelas_id == $kelas_id && $item->akses_worship_character == 1;
            })->count() > 0 ? 1 : 0
        ];

        return view('staf.worship.create-assessment', compact('categories', 'students', 'staff_acces'));
    }

    /**
     * Store a newly created assessment
     */
    public function storeNewAssessment(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'category_id' => 'required|exists:worship_character_categories,id',
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string'
        ]);

        $staff = session('staff');

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_worship_character', true)
            ->whereHas('worshipCategories', function ($query) use ($request) {
                $query->where('worship_character_categories.id', $request->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk kategori ini')
                ->withInput();
        }

        // Check if assessment already exists
        $existingAssessment = WorshipStudentAssessment::where('category_id', $request->category_id)
            ->where('siswa_id', $request->siswa_id)
            ->first();

        if ($existingAssessment) {
            // Update existing assessment
            $existingAssessment->update([
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
            ]);

            return redirect()->route('staff.worship.index')
                ->with('success', 'Penilaian berhasil diperbarui');
        } else {
            // Create new assessment
            WorshipStudentAssessment::create([
                'category_id' => $request->category_id,
                'siswa_id' => $request->siswa_id,
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'created_by' => $request->created_by,
            ]);

            return redirect()->route('staff.worship.index')
                ->with('success', 'Penilaian berhasil disimpan');
        }
    }

    /**
     * Update an assessment via modal
     */
    public function updateAssessment(Request $request, $id)
    {
        $request->validate([
            'predicate' => 'required|string|max:1',
            'explanation' => 'required|string|max:255',
            'created_by' => 'required|string'
        ]);

        $staff = session('staff');
        $assessment = WorshipStudentAssessment::findOrFail($id);

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_worship_character', true)
            ->whereHas('worshipCategories', function ($query) use ($assessment) {
                $query->where('worship_character_categories.id', $assessment->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.worship.index')
                ->with('error', 'Anda tidak memiliki akses untuk kategori ini');
        }

        // Update assessment
        $assessment->update([
            'predicate' => $request->predicate,
            'explanation' => $request->explanation,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('staff.worship.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Delete an assessment
     */
    public function deleteAssessment($id)
    {
        $assessment = WorshipStudentAssessment::findOrFail($id);
        $staff = session('staff');

        // Check if staff has access to this category
        $hasAccess = StaffAcces::where('staff_id', $staff->id)
            ->where('akses_worship_character', true)
            ->whereHas('worshipCategories', function ($query) use ($assessment) {
                $query->where('worship_character_categories.id', $assessment->category_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('staff.worship.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus penilaian ini');
        }

        $assessment->delete();

        return redirect()->route('staff.worship.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }

    public function assessmentByCategory($kelasId, $categoryId)
    {
        // Verify staff access
        $staff = StaffAcces::where('staff_id', session('staff')->id)
            ->where('kelas_id', $kelasId)
            ->where('akses_extrakurikuler', 1)
            ->whereHas('extrakurikulerCategories', function ($query) use ($categoryId) {
                $query->where('extrakurikuler_categories.id', $categoryId);
            })
            ->first();

        if (!$staff) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk kategori ini');
        }

        $category = ExtrakurikulerCategory::findOrFail($categoryId);

        // Get students in this class with their assessments for this category
        $students = Siswa::whereHas('kelas', function ($query) use ($kelasId) {
            $query->where('kelas.id', $kelasId);
        })->with(['extrakurikulerAssessments' => function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        }])->get();

        // Get assessments for this category and class
        $assessments = ExtrakurikulerStudentAssessment::where('category_id', $categoryId)
            ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
                $query->where('kelas.id', $kelasId);
            })
            ->with(['siswa', 'category'])
            ->latest()
            ->get();

        return view('staf.extrakurikuler.assessment-by-category', compact(
            'category',
            'students',
            'assessments',
            'kelasId'
        ));
    }
}
