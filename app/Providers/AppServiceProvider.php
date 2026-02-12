<?php

namespace App\Providers;

use App\Mail\PasswordResetMail;
use App\Models\PageSection;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share Wedding Day date with header so "Save The Date" and countdown use same date as Page Sections
        View::composer('partials.header', function ($view) {
            $weddingDate = PageSection::weddingDate();
            $view->with('headerWeddingDate', $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027');
            $view->with('headerWeddingDateIso', $weddingDate ? $weddingDate->format('Y-m-d\TH:i:s') : '2027-01-01T12:00:00');
        });

        // Use custom password reset email (same UI as Account Approved email)
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            $expireMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60);

            return new PasswordResetMail($notifiable, $resetUrl, $expireMinutes);
        });
    }
}
