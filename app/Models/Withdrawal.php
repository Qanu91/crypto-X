<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
    'user_id',
    'currency',
    'amount',
    'wallet_address',
    'withdrawal_method',
    'account_title',
    'status'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}