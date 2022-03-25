<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract
{
    public function find(int $userId);
}
