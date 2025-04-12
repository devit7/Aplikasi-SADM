<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ortuController;
use App\Http\Controllers\Walas\ManajemenAbsen;
use App\Http\Controllers\Walas\ManajemenNilai;
use App\Http\Controllers\WalasController;
use Illuminate\Support\Facades\Route;

//WALAS
Route::get('/walas/login', function () {
    return view('walas.login-walas');
})->name('loginWalas');

Route::post('/walas/login', [AuthController::class, 'loginWalas']);
Route::post('/logout', [AuthController::class, 'logoutWalas'])->name('logoutWalas');


Route::middleware(['WebAkses:walikelas'])->group(function () {
    //Start - MANAJEMEN NILAI
    Route::get('walas/manajemen-nilai', [ManajemenNilai::class, 'index']);
    Route::get('walas/manajemen-nilai/{id}', [ManajemenNilai::class, 'show']);
    Route::post('walas/manajemen-nilai', [ManajemenNilai::class, 'store']);

    //Start - MANAJEMEN ABSEN
    Route::get('walas/manajemen-absen', [ManajemenAbsen::class, 'index']);
    Route::post('walas/manajemen-absen/store', [ManajemenAbsen::class, 'store'])->name('walas.manajemen-absen.store');
    Route::get('walas/manajemen-absen/{tanggal}', [ManajemenAbsen::class, 'show'])->name('walas.manajemen-absen.show');
    Route::post('walas/manajemen-absen/simpan', [ManajemenAbsen::class, 'simpanPresensi'])->name('walas.manajemen-absen.simpan');

    Route::resource('/walas', WalasController::class);
    Route::get('/walas/{id}', [WalasController::class, 'show'])->name('List-Siswa');
});

Route::get('/ortu/login', [ortuController::class, 'showLoginForm'])->name('ortu.login-ortu');
Route::post('/ortu/login', [ortuController::class, 'loginOrangTua']);
Route::post('/ortu', [ortuController::class, 'logoutOrtu'])->name('logoutortu');


Route::get('/ortu/login', function () {
    return view('ortu.login-ortu');
});
Route::get('/ortu', function () {
    return view('ortu.index');
});
Route::get('/Profile', function () {
    return view('ortu.ProfileSiswa-Ortu');
});

Route::get('/ortu/history-akademik', function () {
    return view('ortu.historyakademik-ortu');
});

Route::get('/ortu/nilai-kehadiran', [ortuController::class, 'getNilai']);
Route::get('/ortu/nilai-kehadiran/kehadiran', [ortuController::class, 'getAbsen']);

route::get('/', function () {
    return view('ortu.historyakademik-ortu');
});
// Route::get('/walas/list-siswa', function () {
//     return view('walas.list-siswa');
// });

//panel orang tua