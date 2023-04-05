<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable =[
        'service_id',
        'entry_id',
        'buy_user',
        'sell_user',
        'price',
        'include_tax_price',
        'commission',
        'session_id',
        'payment_intent',
        'cancel_fee'
    ];
}
