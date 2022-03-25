<?php

namespace App\Services\V1\Contracts;

interface UserServiceContract
{
    public function find(int $userId);
}
