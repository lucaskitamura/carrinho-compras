<?php

namespace App\Services\V1\Contracts;

interface SaleServiceContract
{
    public function store(array $data);
    public function list();
    public function listByUserId(int $userId);
}
