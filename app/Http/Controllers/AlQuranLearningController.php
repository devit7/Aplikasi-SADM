<?php

namespace App\Http\Controllers;

use App\Models\AlQuranLearningCategory;
use App\Models\AlQuranLearningSubcategory;
use App\Models\AlQuranStudentAssessment;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\StaffAcces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlQuranLearningController extends Controller
{
    /**
     * Display a listing of the categories
     */
    public function index()
    {
        $categories = AlQuranLearningCategory::with('subcategories')->get();
        return view('al-quran.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function createCategory()
    {
        return view('al-quran.create-category');
    }

    /**
     * Store a newly created category
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        AlQuranLearningCategory::create($request->all());

        return redirect()->route('al-quran.index')->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing a category
     */
    public function editCategory($id)
    {
        $category = AlQuranLearningCategory::findOrFail($id);
        return view('al-quran.edit-category', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = AlQuranLearningCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('al-quran.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category
     */
    public function destroyCategory($id)
    {
        $category = AlQuranLearningCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('al-quran.index')->with('success', 'Category deleted successfully');
    }

    /**
     * Show the form for creating a new subcategory
     */
    public function createSubcategory($categoryId)
    {
        $category = AlQuranLearningCategory::findOrFail($categoryId);
        return view('al-quran.create-subcategory', compact('category'));
    }

    /**
     * Store a newly created subcategory
     */
    public function storeSubcategory(Request $request, $categoryId)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'predicates' => 'nullable|array',
            'explanations' => 'nullable|array',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = AlQuranLearningCategory::findOrFail($categoryId);

        $subcategory = new AlQuranLearningSubcategory($request->all());
        $subcategory->category_id = $categoryId;
        $subcategory->save();

        return redirect()->route('al-quran.index')->with('success', 'Subcategory created successfully');
    }

    /**
     * Show the form for editing a subcategory
     */
    public function editSubcategory($id)
    {
        $subcategory = AlQuranLearningSubcategory::with('category')->findOrFail($id);
        return view('al-quran.edit-subcategory', compact('subcategory'));
    }

    /**
     * Update the specified subcategory
     */
    public function updateSubcategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'predicates' => 'nullable|array',
            'explanations' => 'nullable|array',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $subcategory = AlQuranLearningSubcategory::findOrFail($id);
        $subcategory->update($request->all());

        return redirect()->route('al-quran.index')->with('success', 'Subcategory updated successfully');
    }

    /**
     * Remove the specified subcategory
     */
    public function destroySubcategory($id)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('al-quran.index')->with('success', 'Subcategory deleted successfully');
    }

    /**
     * Show the list of students for assessments
     */
    public function showStudents($subcategoryId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $accessibleClasses = [];

        $user = Auth::user();
        if ($user->role == 'admin') {
            // Admins can access all classes
            $accessibleClasses = $subcategory->kelas()->pluck('kelas.id')->toArray();
        } else {
            // For staff, check their access
            $staffAccess = StaffAcces::where('staff_id', $user->staff->id)->get();
            $accessibleClasses = $staffAccess->pluck('kelas_id')->toArray();
        }

        $students = Siswa::whereHas('kelas', function ($query) use ($accessibleClasses) {
            $query->whereIn('kelas.id', $accessibleClasses);
        })->get();

        return view('al-quran.students', compact('subcategory', 'students'));
    }

    /**
     * Show the form for creating/editing an assessment
     */
    public function manageAssessment($subcategoryId, $siswaId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $siswa = Siswa::findOrFail($siswaId);

        $assessment = AlQuranStudentAssessment::where('subcategory_id', $subcategoryId)
            ->where('siswa_id', $siswaId)
            ->first();

        return view('al-quran.manage-assessment', compact('subcategory', 'siswa', 'assessment'));
    }

    /**
     * Store a newly created or update existing assessment
     */
    public function storeAssessment(Request $request, $subcategoryId, $siswaId)
    {
        $validator = Validator::make($request->all(), [
            'predicate' => 'required|string|max:10',
            'explanation' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $assessment = AlQuranStudentAssessment::updateOrCreate(
            [
                'subcategory_id' => $subcategoryId,
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

        return redirect()->route('al-quran.students', $subcategoryId)->with('success', 'Assessment saved successfully');
    }

    /**
     * Manage subcategory access for staff
     */
    public function manageStaffAccess($subcategoryId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $staffAccessIds = $subcategory->staffAccesses->pluck('id')->toArray();
        $allStaffAccesses = StaffAcces::with('staff')->get();

        return view('al-quran.staff-access', compact('subcategory', 'staffAccessIds', 'allStaffAccesses'));
    }

    /**
     * Update staff access for a subcategory
     */
    public function updateStaffAccess(Request $request, $subcategoryId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $subcategory->staffAccesses()->sync($request->staff_access_ids);

        return redirect()->route('al-quran.index')->with('success', 'Staff access updated successfully');
    }

    /**
     * Manage class assignments for a subcategory
     */
    public function manageClassAssignments($subcategoryId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $assignedClassIds = $subcategory->kelas->pluck('id')->toArray();
        $allClasses = Kelas::all();

        return view('al-quran.class-assignments', compact('subcategory', 'assignedClassIds', 'allClasses'));
    }

    /**
     * Update class assignments for a subcategory
     */
    public function updateClassAssignments(Request $request, $subcategoryId)
    {
        $subcategory = AlQuranLearningSubcategory::findOrFail($subcategoryId);
        $subcategory->kelas()->sync($request->class_ids);

        return redirect()->route('al-quran.index')->with('success', 'Class assignments updated successfully');
    }
}
