<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LoanRepository;
use App\Services\EMIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        $this->app->singleton(EMIService::class, function ($app) {
           
            return new EMIService($app->make(LoanRepository::class));
        });

        $this->app->singleton(LoanRepository::class, function ($app) {
            return new LoanRepository();
        });
        

        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
