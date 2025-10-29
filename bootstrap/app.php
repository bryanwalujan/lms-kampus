<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole; // Import middleware custom

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ REGISTER ALIAS MIDDLEWARE (seperti Kernel.php lama)
        $middleware->alias([
            'role' => CheckRole::class, // Role check middleware
        ]);

        // ✅ MIDDLEWARE PRIORITAS
        $middleware->prependToGroup('web', [
            // Tambah middleware global web jika perlu
        ]);

        // ✅ MIDDLEWARE GROUPS
        $middleware->web(append: [
            // Web middleware tambahan
        ]);

        $middleware->api(prepend: [
            // API middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();