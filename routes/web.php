<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalasController;
use Illuminate\Support\Facades\Route;


//WALAS
Route::get('/walas/login', function () {
    return view('walas.login-walas');
})->name('loginWalas');

Route::post('/walas/login', [AuthController::class, 'loginWalas']);
Route::post('/logout', [AuthController::class, 'logoutWalas'])->name('logoutWalas');

Route::middleware('auth')->group(function () {
    Route::resource('/walas', WalasController::class);
    Route::get('walas/{id}', [WalasController::class, 'show'])->name('List-Siswa');
});;
// Route::get('/walas/list-siswa', function () {
//     return view('walas.list-siswa');
// });

//panel orang tua
Route::get('/ortu/login', function () {
    return view('ortu.login-ortu');
});
Route::get('/ortu', function () {
    return view('ortu.index');
});

Route::get('/ortu/history-akademik', function () {
    return view('ortu.historyakademik-ortu');
});
Route::get('/ortu/nilai-kehadiran', function () {
    return view('ortu.nilai-kehadiran-ortu');
});
