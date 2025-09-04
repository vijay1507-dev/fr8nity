<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\{SeedTrack,SendMembershipExpiryReminders,ActivatePendingRenewals};
use App\Http\Middleware\{SetTimezone,AdminAccess,EnsureKycIsComplete};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        SeedTrack::class,
        SendMembershipExpiryReminders::class,
        ActivatePendingRenewals::class,
    ])
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('membership:send-expiry-reminders')->daily();
        $schedule->command('membership:activate-renewals')->everyMinute();
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware
        $middleware->web([
            SetTimezone::class,
        ]);

        // Register route middleware aliases
        $middleware->alias([
            'admin' => AdminAccess::class,
            'kyc.complete' => EnsureKycIsComplete::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You can register custom exception handling here if needed
    })
    ->create();
