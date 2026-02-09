<?php

namespace App\Providers;

use App\Models\PageSection;
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
            $view->with('headerWeddingDate', $weddingDate ? $weddingDate->format('m-d-Y') : '12-31-2026');
            $view->with('headerWeddingDateIso', $weddingDate ? $weddingDate->format('Y-m-d\TH:i:s') : '2026-12-31T12:00:00');
        });
    }
}
