<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identification_photo',
        'identification_photo_2',
        'identification_agreement'
    ];
}
