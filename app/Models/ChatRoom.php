<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'apply_id',
        'consult_id',
        'user_id_one',
        'user_id_another',
    ];
}
