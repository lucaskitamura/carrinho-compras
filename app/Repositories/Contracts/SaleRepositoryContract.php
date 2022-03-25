<?php

namespace App\Repositories\Contracts;

interface SaleRepositoryContract
{
    public function store(array $data);
    public function all();
    public function listByUserId(int $userId);
}
