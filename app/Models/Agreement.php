<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'buy_user',
        'sell_user',
        'service_id',
        'entry_id',
        'main_title',
        'content',
        'price',
        'price_net',
        'delivery_deadline',
        'free',
        'status',
        'session_id'
    ];
}
