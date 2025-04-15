<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Walas\ManajemenAbsen;
use App\Http\Controllers\Walas\ManajemenNilai;
use App\Http\Controllers\WalasController;
use Illuminate\Support\Facades\Route;

//WALAS
Route::get('/walas/login', function () {
    return view('walas.login-walas');
})->name('loginWalas');

Route::post('/walas/login', [AuthController::class, 'loginWalas']);
Route::post('/logout', [AuthController::class, 'logoutWalas'])->name('walas.logout');

// Walas
Route::prefix('walas')->middleware(['WebAkses:walikelas'])->group(function () {
    Route::get('/', [WalasController::class, 'index'])->name('walas.index');
    Route::get('/list-siswa/{id}', [WalasController::class, 'show'])->name('walas.list-siswa');

    //Start - MANAJEMEN NILAI
    Route::get('/manajemen-nilai', [ManajemenNilai::class, 'index'])->name('walas.manajemen-nilai.index');
    Route::get('/manajemen-nilai/{id}', [ManajemenNilai::class, 'show']);
    Route::post('/manajemen-nilai', [ManajemenNilai::class, 'store']);

    //Start - MANAJEMEN ABSEN
    Route::get('/manajemen-absen', [ManajemenAbsen::class, 'index'])->name('walas.manajemen-absen.index');
    Route::post('/manajemen-absen/store', [ManajemenAbsen::class, 'store'])->name('walas.manajemen-absen.store');
    Route::get('/manajemen-absen/{tanggal}', [ManajemenAbsen::class, 'show'])->name('walas.manajemen-absen.show');
    Route::post('/manajemen-absen/simpan', [ManajemenAbsen::class, 'simpanPresensi'])->name('walas.manajemen-absen.simpan');

});

<<<<<<< Updated upstream
// ORTU
Route::prefix('ortu')->group(function () {
    Route::get('/profile', [ortuController::class, 'showProfile'])->name('ortu.profile');
    route::get('/', [ortuController::class, 'index'])->name('ortu.index');
    Route::get('/nilai-kehadiran', [ortuController::class, 'showPageNilai'])->name('ortu.nilai');
    Route::get('/nilai-kehadiran/kehadiran', [ortuController::class, 'showPageKehadiran'])->name('ortu.kehadiran');
    Route::get('/login', function () {
        return view('ortu.login-ortu');
    });
});
Route::get('/ortu/login', [ortuController::class, 'showLoginForm'])->name('ortu.login-ortu');
Route::post('/ortu/login', [ortuController::class, 'loginOrangTua']);
Route::post('/ortu', [ortuController::class, 'logoutOrtu'])->name('logoutortu');


=======
//ortu

Route::get('/ortu/login', function () {
    return view('ortu.login-ortu');
})->name('loginOrtu');

Route::post('/ortu/login', [AuthController::class, 'loginOrtu']);
Route::post('/logoutortu', [AuthController::class, 'logoutOrtu'])->name('ortu.logout');


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
>>>>>>> Stashed changes

route::get('/', function () {
    return view('ortu.historyakademik-ortu');
});


// Route::get('/walas/list-siswa', function () {
//     return view('walas.list-siswa');
// });

//panel orang tua