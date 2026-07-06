<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Models\Cart;
use App\Policies\CartPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // Gunakan Bootstrap 5 untuk tampilan pagination
        Paginator::useBootstrapFive();

        // Daftarkan Cart Policy
        Gate::policy(Cart::class, CartPolicy::class);
    }
}
