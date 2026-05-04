<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Pest\Arch\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
       
        Schema::defaultStringLength(190);
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5174');
            return $frontendUrl . "/reset-password?token={$token}&email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
