<?php

use Illuminate\Support\Facades\Route;

Route::get('/walas', function () {
    return view('walas.dashboard-walas');
});
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