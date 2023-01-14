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
        'ohakamairi_sum',
        'sanpai_sum',
        'goshuin_content',
        'spot',
        'offering',
        'cleaning',
        'amulet',
        'img_url',
        'praying',
        'goshuin',
        'free',
        'status_id',
    ];
}
