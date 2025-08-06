<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Console\Commands\SeedTrack;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        SeedTrack::class
    ])
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware
        $middleware->web([
            \App\Http\Middleware\SetTimezone::class,
        ]);
        // Register middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAccess::class,
            'kyc.complete' => \App\Http\Middleware\EnsureKycIsComplete::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
