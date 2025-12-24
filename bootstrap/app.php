<?php

use App\Http\Middleware\EnsureApiAuthenticated;
use App\Http\Middleware\RoleMiddleware;
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
            'api.auth' => EnsureApiAuthenticated::class,
            'role' => RoleMiddleware::class,
            'jwt_secret' => env('JWT_SECRET')
        $middleware->validateCsrfTokens(except: [
            'webhook/xendit', // Kecualikan route ini dari proteksi CSRF
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
