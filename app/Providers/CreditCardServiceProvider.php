<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\V1\CreditCard\CreditCardService;
use App\Repositories\Eloquent\CreditCardRepository;
use App\Services\V1\Contracts\CreditCardServiceContract;
use App\Repositories\Contracts\CreditCardRepositoryContract;

class CreditCardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CreditCardRepositoryContract::class, CreditCardRepository::class);
        $this->app->bind(CreditCardServiceContract::class, CreditCardService::class);
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
