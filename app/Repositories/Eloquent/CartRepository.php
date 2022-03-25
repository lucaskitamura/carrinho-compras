<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CartRepositoryContract;
use App\Models\Cart;

class CartRepository extends AbstractRepository implements CartRepositoryContract
{
    protected $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function listAllProducts(int $userId)
    {
        return $this->model::with(['product'])->whereHas('product', function($product) {
            $product->where('quantity', '>', 0);
        })
        ->where('user_id', $userId)
        ->get();
    }

    public function decrementProductsQuantity(object $cartItem):void
    {
        $cartItem->Product->decrement('quantity', $cartItem->quantity);
    }
}
