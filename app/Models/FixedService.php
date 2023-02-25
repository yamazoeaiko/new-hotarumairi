<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'consult_id',
        'host_user',
        'buy_user',
        'main_title',
        'price',
        'content',
        'date_end'
    ];
}
