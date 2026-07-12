<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
    protected $fillable = [
        'user_id',
        'currency',
        'amount',
        'payment_method',
        'account_title',
        'account_number',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}