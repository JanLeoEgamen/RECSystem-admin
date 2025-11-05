<?php

use App\Console\Commands\CheckMembershipExpirations;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )       
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'approved.applicant' => \App\Http\Middleware\EnsureApplicantIsApproved::class,
            'application.incomplete' => \App\Http\Middleware\EnsureApplicationIsComplete::class,
            'active.membership' => App\Http\Middleware\EnsureMembershipIsActive::class,
        ]); 
        
        // Add as global middleware (runs on every request)
        $middleware->web(append: [
            \App\Http\Middleware\RedirectPendingApplicants::class,
            \App\Http\Middleware\RedirectByRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withCommands([
        CheckMembershipExpirations::class,
    ])
    ->withSchedule(function (Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('membership:check-expirations')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Manila');
    })
    ->create();
