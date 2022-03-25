<?php

namespace App\Repositories\Contracts;

interface CreditCardRepositoryContract
{
    public function find(int $creditCardId);
    public function store(array $data);
    public function update(int $creditCardId, array $data);
    public function delete(int $creditCardId);
}
