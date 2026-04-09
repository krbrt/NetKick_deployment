<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
    // This tells Fortify to use your custom login blade
    Fortify::loginView(function () {
        return view('auth.login');
    });

    // This tells Fortify to use your 2FA challenge blade
    Fortify::twoFactorChallengeView(function () {
        return view('auth.two-factor-challenge');
    });

    Fortify::confirmPasswordView(function () {
        return view('auth.confirm-password');
    });
}
}
