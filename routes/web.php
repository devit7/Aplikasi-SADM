<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('walas.dashboard-walas');
});

Route::get('/ortu', function () {
    return view('ortu.index');
});

Route::get('/ortu/nilai-kehadiran', function () {
    return view('ortu.nilai-kehadiran-ortu');
});