<?php

namespace App\Services\V1\Cart;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Services\V1\Contracts\CartServiceContract;
use App\Repositories\Contracts\CartRepositoryContract;

class CartService implements CartServiceContract
{
    private $cartRepositoryContract;

    const CART_CACHE_TIME = 36000;

    public function __construct(CartRepositoryContract $cartRepositoryContract)
    {
        $this->cartRepositoryContract = $cartRepositoryContract;
    }

    public function listAllProducts(int $userId): Collection
    {
        return Cache::remember('cart_'.$userId, self::CART_CACHE_TIME, function() use($userId) {
            return $this->cartRepositoryContract->listAllProducts($userId);
        });
    }

    public function removeCartCache(int $userId): void
    {
        Cache::forget('cart_'.$userId);
    }

    public function getCartProductsSum($cart)
    {
        return $cart->sum(function($item) {
            return $item->quantity * $item->Product->price;
        });
    }

    public function decrementCartProductsQuantityFromProducts(object $cartItem):void
    {
        $this->cartRepositoryContract->decrementProductsQuantity($cartItem);
    }
}
