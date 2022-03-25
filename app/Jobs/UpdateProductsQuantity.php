<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\V1\Cart\CartService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Services\V1\Contracts\CartServiceContract;

class UpdateProductsQuantity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cart;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CartServiceContract $cartServiceContract)
    {
        $this->cart->map(function ($cartItem) use ($cartServiceContract){
            $cartServiceContract->decrementCartProductsQuantityFromProducts($cartItem);
        });
    }
}
