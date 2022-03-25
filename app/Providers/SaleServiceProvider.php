<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\V1\Sale\SaleService;
use App\Services\V1\Contracts\SaleServiceContract;
use App\Repositories\Eloquent\SaleRepository;
use App\Repositories\Contracts\SaleRepositoryContract;

class SaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SaleRepositoryContract::class, SaleRepository::class);
        $this->app->bind(SaleServiceContract::class, SaleService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
