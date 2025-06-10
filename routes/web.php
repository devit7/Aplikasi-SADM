<?php

use App\Http\Controllers\AlQuranLearningController;
use App\Http\Controllers\ExtrakurikulerController;
use App\Http\Controllers\OrtuAuthController;
use App\Http\Controllers\Walas\ManajemenAbsen;
use App\Http\Controllers\Walas\ManajemenNilai;
use App\Http\Controllers\WalasController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\StafAuthController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\StaffManajemenAbsen;
use App\Http\Controllers\Staff\StaffManajemenNilai;
use App\Http\Controllers\WalasAuthController;
use App\Http\Controllers\WorshipCharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/ortu');
})->name('home');

//WALAS
Route::get('/walas/login', function () {
    return view('walas.login-walas');
})->name('loginWalas');
Route::post('/walas/login', [WalasAuthController::class, 'loginWalas']);
Route::post('/logout', [WalasAuthController::class, 'logoutWalas'])->name('walas.logout');

// WALAS MANAJEMEN
Route::prefix('walas')->middleware(['WebAkses:walikelas'])->group(function () {
    Route::get('/', [WalasController::class, 'index'])->name('walas.index');
    Route::get('/list-siswa/{id}', [WalasController::class, 'show'])->name('walas.list-siswa');

    //Start - MANAJEMEN NILAI
    Route::get('/manajemen-nilai', [ManajemenNilai::class, 'index'])->name('walas.manajemen-nilai.index');
    Route::get('/manajemen-nilai/{id}', [ManajemenNilai::class, 'show'])->name('walas.manajemen-nilai.show');
    Route::post('/manajemen-nilai', [ManajemenNilai::class, 'store'])->name('walas.manajemen-nilai.store');
    //End - MANAJEMEN NILAI

    //Start - MANAJEMEN ABSEN
    Route::get('/manajemen-absen', [ManajemenAbsen::class, 'index'])->name('walas.manajemen-absen.index');
    Route::post('/manajemen-absen/store', [ManajemenAbsen::class, 'store'])->name('walas.manajemen-absen.store');
    Route::get('/manajemen-absen/{tanggal}', [ManajemenAbsen::class, 'show'])->name('walas.manajemen-absen.show');
    Route::post('/manajemen-absen/simpan', [ManajemenAbsen::class, 'simpanPresensi'])->name('walas.manajemen-absen.simpan');
    //End - MANAJEMEN ABSEN
});

Route::get('/ortu/login', [OrtuAuthController::class, 'showLoginForm'])->name('ortu.login-ortu');
Route::post('/ortu/login', [OrtuAuthController::class, 'loginOrtu']);
Route::post('/ortu/logout', [OrtuAuthController::class, 'logoutOrtu'])->name('ortu.logout');

//ORTU MANAJEMEN
Route::prefix('ortu')->middleware(['ortuAkses'])->group(function () {

    Route::get('/', [OrtuController::class, 'index'])->name('ortu.index');
    Route::get('/profile', [OrtuController::class, 'showProfile'])->name('ortu.profile');
    Route::get('/nilai-kehadiran', [OrtuController::class, 'showPageNilai'])->name('ortu.nilai');
    Route::get('/nilai-kehadiran/kehadiran', [OrtuController::class, 'showPageKehadiran'])->name('ortu.kehadiran');
    Route::get('/nilai-kehadiran/showReport', [OrtuController::class, 'showRaport'])->name('ortu.showRaport');
});


//STAF AUTH
Route::get('/staff/login', [StafAuthController::class, 'showLoginForm'])->name('staf.login-staf');
Route::post('/staff/login', [StafAuthController::class, 'loginStaf']);
Route::post('/staff/logout', [StafAuthController::class, 'logoutStaf'])->name('staf.logout');

//STAFF MANAJEMEN
Route::prefix('staff')->middleware(['stafAkses'])->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/list-siswa/{id}', [StaffController::class, 'show'])->name('staff.list-siswa');

    //Start - MANAJEMEN ABSEN
    Route::get('/manajemen-absen', [StaffManajemenAbsen::class, 'index'])->name('staff.manajemen-absen.index');
    Route::post('/manajemen-absen/store', [StaffManajemenAbsen::class, 'store'])->name('staff.manajemen-absen.store');
    Route::get('/manajemen-absen/{tanggal}', [StaffManajemenAbsen::class, 'show'])->name('staff.manajemen-absen.show');
    Route::post('/manajemen-absen/simpan', [StaffManajemenAbsen::class, 'simpanPresensi'])->name('staff.manajemen-absen.simpan');
    //End - MANAJEMEN ABSEN

    Route::get('/manajemen-nilai', [StaffManajemenNilai::class, 'index'])->name('staff.manajemen-nilai.index');
    Route::get('/manajemen-nilai/{id}', [StaffManajemenNilai::class, 'show'])->name('staff.manajemen-nilai.show');
    Route::post('/manajemen-nilai', [StaffManajemenNilai::class, 'store'])->name('staff.manajemen-nilai.store');
    //End - MANAJEMEN NILAI

    // Start - AL QURAN LEARNING ROUTES
    Route::prefix('al-quran')->group(function () {
        Route::get('/', [AlQuranLearningController::class, 'index'])->name('al-quran.index');
        Route::get('/create', [AlQuranLearningController::class, 'createCategory'])->name('al-quran.create');
        Route::post('/', [AlQuranLearningController::class, 'storeCategory'])->name('al-quran.store');
        Route::get('/{id}/edit', [AlQuranLearningController::class, 'editCategory'])->name('al-quran.edit');
        Route::put('/{id}', [AlQuranLearningController::class, 'updateCategory'])->name('al-quran.update');
        Route::delete('/{id}', [AlQuranLearningController::class, 'destroyCategory'])->name('al-quran.destroy');

        // Subcategory routes
        Route::get('/{categoryId}/subcategory/create', [AlQuranLearningController::class, 'createSubcategory'])->name('al-quran.subcategory.create');
        Route::post('/{categoryId}/subcategory', [AlQuranLearningController::class, 'storeSubcategory'])->name('al-quran.subcategory.store');
        Route::get('/subcategory/{id}/edit', [AlQuranLearningController::class, 'editSubcategory'])->name('al-quran.subcategory.edit');
        Route::put('/subcategory/{id}', [AlQuranLearningController::class, 'updateSubcategory'])->name('al-quran.subcategory.update');
        Route::delete('/subcategory/{id}', [AlQuranLearningController::class, 'destroySubcategory'])->name('al-quran.subcategory.destroy');

        // Assessment routes
        Route::get('/subcategory/{id}/students', [AlQuranLearningController::class, 'showStudents'])->name('al-quran.students');
        Route::get('/subcategory/{subcategoryId}/student/{siswaId}/assessment', [AlQuranLearningController::class, 'manageAssessment'])->name('al-quran.assessment');
        Route::post('/subcategory/{subcategoryId}/student/{siswaId}/assessment', [AlQuranLearningController::class, 'storeAssessment'])->name('al-quran.assessment.store');

        // Staff Access routes
        Route::get('/subcategory/{id}/staff-access', [AlQuranLearningController::class, 'manageStaffAccess'])->name('al-quran.staff-access');
        Route::post('/subcategory/{id}/staff-access', [AlQuranLearningController::class, 'updateStaffAccess'])->name('al-quran.staff-access.update');

        // Class Assignments routes
        Route::get('/subcategory/{id}/class-assignments', [AlQuranLearningController::class, 'manageClassAssignments'])->name('al-quran.class-assignments');
        Route::post('/subcategory/{id}/class-assignments', [AlQuranLearningController::class, 'updateClassAssignments'])->name('al-quran.class-assignments.update');
    });
    // End - AL QURAN LEARNING ROUTES

    // Start - EXTRAKURIKULER ROUTES
    Route::prefix('extrakurikuler')->group(function () {
        Route::get('/', [ExtrakurikulerController::class, 'index'])->name('extrakurikuler.index');
        Route::get('/create', [ExtrakurikulerController::class, 'createCategory'])->name('extrakurikuler.create');
        Route::post('/', [ExtrakurikulerController::class, 'storeCategory'])->name('extrakurikuler.store');
        Route::get('/{id}/edit', [ExtrakurikulerController::class, 'editCategory'])->name('extrakurikuler.edit');
        Route::put('/{id}', [ExtrakurikulerController::class, 'updateCategory'])->name('extrakurikuler.update');
        Route::delete('/{id}', [ExtrakurikulerController::class, 'destroyCategory'])->name('extrakurikuler.destroy');

        // Assessment routes
        Route::get('/{id}/students', [ExtrakurikulerController::class, 'showStudents'])->name('extrakurikuler.students');
        Route::get('/{categoryId}/student/{siswaId}/assessment', [ExtrakurikulerController::class, 'manageAssessment'])->name('extrakurikuler.assessment');
        Route::post('/{categoryId}/student/{siswaId}/assessment', [ExtrakurikulerController::class, 'storeAssessment'])->name('extrakurikuler.assessment.store');

        // Staff Access routes
        Route::get('/{id}/staff-access', [ExtrakurikulerController::class, 'manageStaffAccess'])->name('extrakurikuler.staff-access');
        Route::post('/{id}/staff-access', [ExtrakurikulerController::class, 'updateStaffAccess'])->name('extrakurikuler.staff-access.update');

        // Class Assignments routes
        Route::get('/{id}/class-assignments', [ExtrakurikulerController::class, 'manageClassAssignments'])->name('extrakurikuler.class-assignments');
        Route::post('/{id}/class-assignments', [ExtrakurikulerController::class, 'updateClassAssignments'])->name('extrakurikuler.class-assignments.update');
    });
    // End - EXTRAKURIKULER ROUTES

    // Start - WORSHIP CHARACTER ROUTES
    Route::prefix('worship')->group(function () {
        Route::get('/', [WorshipCharacterController::class, 'index'])->name('worship.index');
        Route::get('/create', [WorshipCharacterController::class, 'createCategory'])->name('worship.create');
        Route::post('/', [WorshipCharacterController::class, 'storeCategory'])->name('worship.store');
        Route::get('/{id}/edit', [WorshipCharacterController::class, 'editCategory'])->name('worship.edit');
        Route::put('/{id}', [WorshipCharacterController::class, 'updateCategory'])->name('worship.update');
        Route::delete('/{id}', [WorshipCharacterController::class, 'destroyCategory'])->name('worship.destroy');

        // Assessment routes
        Route::get('/{id}/students', [WorshipCharacterController::class, 'showStudents'])->name('worship.students');
        Route::get('/{categoryId}/student/{siswaId}/assessment', [WorshipCharacterController::class, 'manageAssessment'])->name('worship.assessment');
        Route::post('/{categoryId}/student/{siswaId}/assessment', [WorshipCharacterController::class, 'storeAssessment'])->name('worship.assessment.store');

        // Staff Access routes
        Route::get('/{id}/staff-access', [WorshipCharacterController::class, 'manageStaffAccess'])->name('worship.staff-access');
        Route::post('/{id}/staff-access', [WorshipCharacterController::class, 'updateStaffAccess'])->name('worship.staff-access.update');

        // Class Assignments routes
        Route::get('/{id}/class-assignments', [WorshipCharacterController::class, 'manageClassAssignments'])->name('worship.class-assignments');
        Route::post('/{id}/class-assignments', [WorshipCharacterController::class, 'updateClassAssignments'])->name('worship.class-assignments.update');
    });
    // End - WORSHIP CHARACTER ROUTES
});

Route::fallback(function () {
    return view('<h1>404 Page Not Found</h1>');
});
