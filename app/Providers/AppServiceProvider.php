<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Events\Login;    // Laravel's built-in login event
use Illuminate\Auth\Events\Logout;  // Laravel's built-in logout event
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

                VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Your Email Address')
                ->view('emails.verify', [
                    'url' => $url,
                    'user' => $notifiable, // Passes the user object to the Blade view
                ]);
        });

        // Log login events
        Event::listen('Illuminate\Auth\Events\Login', function ($event) {
            if ($event->user->member ?? false) {
                logMemberLogin(
                    $event->user->member,
                    'User logged in',
                    ['ip' => request()->ip(), 'user_agent' => request()->userAgent()]
                );
            }
        });

        // Log logout events
        Event::listen('Illuminate\Auth\Events\Logout', function ($event) {
            if ($event->user->member ?? false) {
                logMemberLogout(
                    $event->user->member,
                    'User logged out',
                    ['ip' => request()->ip(), 'user_agent' => request()->userAgent()]
                );
            }
        });
    }    
}
