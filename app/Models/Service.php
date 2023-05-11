<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_user_id',
        'offer_user_id',
        'category_ids',
        'main_title',
        'content',
        'photo_1',
        'photo_2',
        'photo_3',
        'photo_4',
        'photo_5',
        'photo_6',
        'photo_7',
        'photo_8',
        'attention',
        'price',
        'price_net',
        'area_id',
        'application_deadline',
        'delivery_deadline',
        'free',
        'session_id',
        'payment_id',
        'status'
    ];

    protected $casts = [
        'category_ids' => 'json',
        'area_id' => 'json'
    ];
}
