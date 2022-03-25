<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'user_id',
        'user_name',
        'credit_card_id',
        'date',
        'amount'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function CreditCard()
    {
        return $this->hasOne(CreditCard::class, 'id', 'credit_card_id');
    }
}
