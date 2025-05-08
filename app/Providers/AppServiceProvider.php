<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Borrow;

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
        // Share active borrows count with all views
        View::composer('*', function ($view) {
            $view->with('activeBorrowsCount', Borrow::where('status', 'borrowed')->count());
        });
    }
}
