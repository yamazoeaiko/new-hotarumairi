<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotaruRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_user_id',
        'plan_id',
        'date_begin',
        'date_end',
        'price',
        'area_id',
        'address',
        'spot',
        'offering',
        'cleaning',
        'amulet',
        'praying',
        'goshuin',
        'free',
        'status_id',
    ];
}
