<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    protected $fillable = [
        'method',
        'account_title',
        'account_number',
        'bank_name'
    ];
}