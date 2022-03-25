<?php

namespace App\Services\V1\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Services\V1\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;

class UserService implements UserServiceContract
{
    private $userRepositoryContract;

    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
    }

    public function find(int $userId)
    {
        return $this->userRepositoryContract->find($userId);
    }
}
