<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('ortu.historyakademik-ortu');
});

Route::get('/ortu', function () {
    return view('ortu/index');
});