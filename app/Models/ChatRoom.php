<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'entry_id',
        'agreement_id',
        'buy_user',
        'sell_user',
        'status'
    ];
}
