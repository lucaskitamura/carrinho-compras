<?php

namespace App\Services\V1\Contracts;

interface CartServiceContract
{
    public function listAllProducts(int $userId);
    public function getCartProductsSum(object $cart);
    public function decrementCartProductsQuantityFromProducts(object $cart);
    public function removeCartCache(int $userId);
}
