<?php

namespace App\Providers;

use App\Services\Contracts\StockService;
use App\Services\Impls\StockServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StockService::class, StockServiceImpl::class);
    }

}
