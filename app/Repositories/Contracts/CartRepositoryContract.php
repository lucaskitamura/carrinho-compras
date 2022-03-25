<?php

namespace App\Repositories\Contracts;

interface CartRepositoryContract
{
    public function listAllProducts(int $userId);
    public function decrementProductsQuantity(object $cart);
}
