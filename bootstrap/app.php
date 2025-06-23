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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'approved.applicant' => \App\Http\Middleware\EnsureApplicantIsApproved::class,
        ]);
        
        // ✅ Add as global middleware (runs on every request)
        $middleware->web(append: [
            \App\Http\Middleware\RedirectPendingApplicants::class, // Now runs AFTER auth
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
