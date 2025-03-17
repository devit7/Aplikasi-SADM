<?php

use App\Http\Controllers\WalasController;
use Illuminate\Support\Facades\Route;

Route::resource('/walas',WalasController::class);
Route::get('walaas/{id}',[WalasController::class, 'showSiswa'])->name('List-Siswa');
Route::get('/walas/list-siswa', function () {
    return view('walas.list-siswa');
});
Route::get('/walas/login', function () {
    return view('walas.login-walas');
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