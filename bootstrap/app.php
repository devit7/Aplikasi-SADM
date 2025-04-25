<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\siswaAkses;
use App\Http\Middleware\webAkses;
use App\Http\Middleware\OrtuAkses;
use App\Http\Middleware\stafAkses;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the siswaAkses middleware
        $middleware->alias([
            'siswa' => siswaAkses::class,
            'WebAkses' => webAkses::class,
            'ortuAkses' => OrtuAkses::class,
            'stafAkses' => stafAkses::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
