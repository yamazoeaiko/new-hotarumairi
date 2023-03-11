<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceConsult extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'host_user',
        'consulting_user',
        'first_chat',
        'status'
    ];
}
