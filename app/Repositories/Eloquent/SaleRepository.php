<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SaleRepositoryContract;
use App\Models\Sale;

class SaleRepository extends AbstractRepository implements SaleRepositoryContract
{
    protected $model;

    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    public function listByUserId(int $userId)
    {
        return $this->model::where('user_id', $userId)->get();
    }
}
