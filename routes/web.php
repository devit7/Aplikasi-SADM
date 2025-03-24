<?php

use Illuminate\Support\Facades\Route;
Route::prefix('walas')->group(function () {
    Route::get('/', function () {
        return view('walas.dashboard-walas');
    });
    Route::get('/list-siswa', function () {
        return view('walas.list-siswa');
    });
    Route::get('/login', function () {
        return view('walas.login-walas');
    });
});

Route::prefix('ortu')->group(function () {
    Route::get('/', function () {
        return view('ortu.index');
    });
    Route::get('/history-akademik', function () {
        return view('ortu.historyakademik-ortu');
    });
    Route::get('/nilai-kehadiran', function () {
        return view('ortu.nilai-kehadiran-ortu');
    });
});