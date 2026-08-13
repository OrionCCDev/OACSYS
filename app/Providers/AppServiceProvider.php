<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The whole app is Bootstrap-themed (Livewire pages already opt into this
        // per-component); classic controller pagination needs the same default,
        // otherwise it falls back to Laravel's Tailwind view, which has no CSS
        // here to hide/show its two responsive blocks - both render stacked.
        Paginator::useBootstrap();
    }
}
