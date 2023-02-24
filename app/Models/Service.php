<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_ids',
        'main_title',
        'content',
        'attention',
        'public_sign',
        'price',
        'price_net',
        'area_id'
    ];

    protected $casts = [
        'category_ids' => 'json',
        'area_id' => 'json'
    ];
}
