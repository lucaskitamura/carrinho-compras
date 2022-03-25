<?php

namespace App\Services\V1\Contracts;

interface AbstractServiceContract
{
    public function store(array $data);
    public function update(int $id, array $data);
    public function find(int $id);
    public function delete(int $id);
}
