<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
    //tive que implementar este método para conseguir realizar uma rota que está dentro do api.php
     public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/api.php'));
    }
}
