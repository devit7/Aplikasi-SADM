<?php

use App\Http\Controllers\AlQuranLearningController;
use App\Http\Controllers\ExtrakurikulerController;
use App\Http\Controllers\OrtuAuthController;
use App\Http\Controllers\Walas\ManajemenAbsen;
use App\Http\Controllers\Walas\ManajemenNilai;
use App\Http\Controllers\WalasController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\StafAuthController;
use App\Http\Controllers\Staff\StaffAlQuranLearningController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\StaffExtrakurikulerController;
use App\Http\Controllers\Staff\StaffManajemenAbsen;
use App\Http\Controllers\Staff\StaffManajemenNilai;
use App\Http\Controllers\Staff\StaffWorshipCharacterController;
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

Route::get('/test', [OrtuController::class, ''])->name('test');
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
Route::get('/staff/login', [StafAuthController::class, 'showLoginForm'])->name('staff.login-staf');
Route::post('/staff/login', [StafAuthController::class, 'loginStaf']);
Route::post('/staff/logout', [StafAuthController::class, 'logoutStaf'])->name('staff.logout');

//STAFF MANAJEMEN
Route::prefix('staff')->middleware(['stafAkses'])->group(function () {
    // Al-Quran assessment by subcategory
    // Route::get(
    //     '/al-quran/kelas/{kelasId}/subcategory/{subcategoryId}',
    //     [StaffAlQuranLearningController::class, 'assessmentBySubcategory']
    // )->name('staff.al-quran.assessment-by-subcategory');

    // // Extrakurikuler assessment by category  
    // Route::get(
    //     '/extrakurikuler/kelas/{kelasId}/category/{categoryId}',
    //     [StaffExtrakurikulerController::class, 'assessmentByCategory']
    // )->name('staff.extrakurikuler.assessment-by-category');

    // // Worship assessment by category
    // Route::get(
    //     '/worship/kelas/{kelasId}/category/{categoryId}',
    //     [StaffWorshipCharacterController::class, 'assessmentByCategory']
    // )->name('staff.worship.assessment-by-category');

    Route::get('/', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/list-siswa/{id}', [StaffController::class, 'show'])->name('staff.list-siswa');

    //Start - MANAJEMEN ABSEN
    Route::get('/manajemen-absen', [StaffManajemenAbsen::class, 'index'])->name('staff.manajemen-absen.index');
    Route::post('/manajemen-absen/store', [StaffManajemenAbsen::class, 'store'])->name('staff.manajemen-absen.store');
    Route::get('/manajemen-absen/{tanggal}', [StaffManajemenAbsen::class, 'show'])->name('staff.manajemen-absen.show');
    Route::post('/manajemen-absen/simpan', [StaffManajemenAbsen::class, 'simpanPresensi'])->name('staff.manajemen-absen.simpan');
    //End - MANAJEMEN ABSEN

    //Start - MANAJEMEN NILAI
    Route::get('/manajemen-nilai', [StaffManajemenNilai::class, 'index'])->name('staff.manajemen-nilai.index');
    Route::get('/manajemen-nilai/{id}', [StaffManajemenNilai::class, 'show'])->name('staff.manajemen-nilai.show');
    Route::post('/manajemen-nilai', [StaffManajemenNilai::class, 'store'])->name('staff.manajemen-nilai.store');
    //End - MANAJEMEN NILAI

    // Start - AL QURAN LEARNING ASSESSMENTS
    Route::prefix('al-quran')->group(function () {
        Route::get('/subcategory/{subcategoryId}', [StaffAlQuranLearningController::class, 'index'])->name('staff.al-quran.index');
        Route::get('/create-assessment', [StaffAlQuranLearningController::class, 'createAssessment'])->name('staff.al-quran.create-assessment');
        Route::post('/store-assessment', [StaffAlQuranLearningController::class, 'storeNewAssessment'])->name('staff.al-quran.store-new-assessment');
        Route::post('/{subcategoryId}/students/{siswaId}/assessment', [StaffAlQuranLearningController::class, 'updateAssessment'])->name('staff.al-quran.update-assessment');
        Route::delete('/assessment/{id}', [StaffAlQuranLearningController::class, 'deleteAssessment'])->name('staff.al-quran.delete-assessment');
    });
    // End - AL QURAN LEARNING ASSESSMENTS

    // Start - EXTRAKURIKULER ROUTES
    Route::prefix('extrakurikuler')->group(function () {
        Route::get('/category/{categoryId}', [StaffExtrakurikulerController::class, 'index'])->name('staff.extrakurikuler.index');
        Route::get('/create-assessment', [StaffExtrakurikulerController::class, 'createAssessment'])->name('staff.extrakurikuler.create-assessment');
        Route::post('/store-assessment', [StaffExtrakurikulerController::class, 'storeNewAssessment'])->name('staff.extrakurikuler.store-new-assessment');
        Route::put('/update-assessment/{id}', [StaffExtrakurikulerController::class, 'updateAssessment'])->name('staff.extrakurikuler.update-assessment');
        Route::delete('/delete-assessment/{id}', [StaffExtrakurikulerController::class, 'deleteAssessment'])->name('staff.extrakurikuler.delete-assessment');
    });
    // End - EXTRAKURIKULER ROUTES

    // Start - WORSHIP CHARACTER ROUTES
    Route::prefix('worship')->group(function () {
        Route::get('/category/{categoryId}', [StaffWorshipCharacterController::class, 'index'])->name('staff.worship.index');
        Route::get('/create-assessment', [StaffWorshipCharacterController::class, 'createAssessment'])->name('staff.worship.create-assessment');
        Route::post('/store-assessment', [StaffWorshipCharacterController::class, 'storeNewAssessment'])->name('staff.worship.store-new-assessment');
        Route::put('/update-assessment/{id}', [StaffWorshipCharacterController::class, 'updateAssessment'])->name('staff.worship.update-assessment');
        Route::delete('/delete-assessment/{id}', [StaffWorshipCharacterController::class, 'deleteAssessment'])->name('staff.worship.delete-assessment');
    });
    // End - WORSHIP CHARACTER ROUTES
});


Route::fallback(function () {
    return view('<h1>404 Page Not Found</h1>');
});
