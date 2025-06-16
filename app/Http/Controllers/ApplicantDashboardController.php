<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ApplicantDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', 'role:applicant']),
        ];
    }

    /**
     * Display the applicant dashboard.
     */
    public function index()
    {
        return view('applicant.dashboard');
    }
}