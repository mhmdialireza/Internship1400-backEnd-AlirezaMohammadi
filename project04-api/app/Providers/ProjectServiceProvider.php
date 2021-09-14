<?php

namespace App\Providers;

use App\Services\AnalyzingService;
use App\Http\Controllers\V1\Types\Poly;
use App\Services\PolyService;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(AnalyzingService::class, function($app){
            return new AnalyzingService();
        });

        $this->app->singleton(PolyService::class, function($app){
            return new PolyService();
        });
    }
}
