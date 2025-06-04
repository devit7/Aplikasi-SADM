<?php

namespace App\Http\Controllers;

use App\Models\ExtrakurikulerCategory;
use App\Models\ExtrakurikulerStudentAssessment;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\StaffAcces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExtrakurikulerController extends Controller
{
    /**
     * Display a listing of the categories
     */
    public function index()
    {
        $categories = ExtrakurikulerCategory::all();
        return view('extrakurikuler.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function createCategory()
    {
        return view('extrakurikuler.create-category');
    }

    /**
     * Store a newly created category
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'predicates' => 'nullable|array',
            'explanations' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ExtrakurikulerCategory::create($request->all());

        return redirect()->route('extrakurikuler.index')->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing a category
     */
    public function editCategory($id)
    {
        $category = ExtrakurikulerCategory::findOrFail($id);
        return view('extrakurikuler.edit-category', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'predicates' => 'nullable|array',
            'explanations' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = ExtrakurikulerCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('extrakurikuler.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category
     */
    public function destroyCategory($id)
    {
        $category = ExtrakurikulerCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('extrakurikuler.index')->with('success', 'Category deleted successfully');
    }

    /**
     * Show the list of students for assessments
     */
    public function showStudents($categoryId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $accessibleClasses = [];

        $user = Auth::user();
        if ($user->role == 'admin') {
            // Admins can access all classes
            $accessibleClasses = $category->kelas()->pluck('kelas.id')->toArray();
        } else {
            // For staff, check their access
            $staffAccess = StaffAcces::where('staff_id', $user->staff->id)->get();
            $accessibleClasses = $staffAccess->pluck('kelas_id')->toArray();
        }

        $students = Siswa::whereHas('kelas', function ($query) use ($accessibleClasses) {
            $query->whereIn('kelas.id', $accessibleClasses);
        })->get();

        return view('extrakurikuler.students', compact('category', 'students'));
    }

    /**
     * Show the form for creating/editing an assessment
     */
    public function manageAssessment($categoryId, $siswaId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $siswa = Siswa::findOrFail($siswaId);

        $assessment = ExtrakurikulerStudentAssessment::where('category_id', $categoryId)
            ->where('siswa_id', $siswaId)
            ->first();

        return view('extrakurikuler.manage-assessment', compact('category', 'siswa', 'assessment'));
    }

    /**
     * Store a newly created or update existing assessment
     */
    public function storeAssessment(Request $request, $categoryId, $siswaId)
    {
        $validator = Validator::make($request->all(), [
            'predicate' => 'required|string|max:10',
            'explanation' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $assessment = ExtrakurikulerStudentAssessment::updateOrCreate(
            [
                'category_id' => $categoryId,
                'siswa_id' => $siswaId
            ],
            [
                'predicate' => $request->predicate,
                'explanation' => $request->explanation,
                'notes' => $request->notes,
                'created_by' => $request->filled('created_by') ? $request->created_by : Auth::id(),
                'updated_by' => Auth::id()
            ]
        );

        return redirect()->route('extrakurikuler.students', $categoryId)->with('success', 'Assessment saved successfully');
    }

    /**
     * Manage category access for staff
     */
    public function manageStaffAccess($categoryId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $staffAccessIds = $category->staffAccesses->pluck('id')->toArray();
        $allStaffAccesses = StaffAcces::with('staff')->get();

        return view('extrakurikuler.staff-access', compact('category', 'staffAccessIds', 'allStaffAccesses'));
    }

    /**
     * Update staff access for a category
     */
    public function updateStaffAccess(Request $request, $categoryId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $category->staffAccesses()->sync($request->staff_access_ids);

        return redirect()->route('extrakurikuler.index')->with('success', 'Staff access updated successfully');
    }

    /**
     * Manage class assignments for a category
     */
    public function manageClassAssignments($categoryId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $assignedClassIds = $category->kelas->pluck('id')->toArray();
        $allClasses = Kelas::all();

        return view('extrakurikuler.class-assignments', compact('category', 'assignedClassIds', 'allClasses'));
    }

    /**
     * Update class assignments for a category
     */
    public function updateClassAssignments(Request $request, $categoryId)
    {
        $category = ExtrakurikulerCategory::findOrFail($categoryId);
        $category->kelas()->sync($request->class_ids);

        return redirect()->route('extrakurikuler.index')->with('success', 'Class assignments updated successfully');
    }
}
