<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CreditCardRepositoryContract;
use App\Models\CreditCard;

class CreditCardRepository extends AbstractRepository implements CreditCardRepositoryContract
{
    protected $model;

    public function __construct(CreditCard $model)
    {
        $this->model = $model;
    }
}
