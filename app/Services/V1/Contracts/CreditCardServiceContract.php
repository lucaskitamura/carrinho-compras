<?php

namespace App\Services\V1\Contracts;

interface CreditCardServiceContract
{
    public function store(array $data);
    public function update(int $creditCardId, array $data);
    public function find(int $creditCardId);
    public function delete(int $creditCardId);
    public function creditCardMasking(string $number, string $maskingCharacter = '*');
}
