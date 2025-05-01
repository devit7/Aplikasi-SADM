<?php

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
use Illuminate\Support\Facades\Route;



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

Route::get('/nilai-kehadiran/showReport', [OrtuController::class, 'showReport']);
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
});
