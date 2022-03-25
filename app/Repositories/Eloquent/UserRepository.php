<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Models\User;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
