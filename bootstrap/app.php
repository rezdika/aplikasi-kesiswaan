<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'kesiswaan' => \App\Http\Middleware\KesiswaanMiddleware::class,
            'kepsek' => \App\Http\Middleware\KepsekMiddleware::class,
            'guru' => \App\Http\Middleware\GuruMiddleware::class,
            'wali_kelas' => \App\Http\Middleware\WalasMiddleware::class,
            'bk' => \App\Http\Middleware\BkMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
            'ortu' => \App\Http\Middleware\OrtuMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
