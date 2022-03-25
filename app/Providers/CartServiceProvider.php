<?php

namespace App\Providers;

use App\Services\V1\Cart\CartService;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\CartRepository;
use App\Services\V1\Contracts\CartServiceContract;
use App\Repositories\Contracts\CartRepositoryContract;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepositoryContract::class, CartRepository::class);
        $this->app->bind(CartServiceContract::class, CartService::class);
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
