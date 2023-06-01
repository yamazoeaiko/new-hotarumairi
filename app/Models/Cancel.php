<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'payment_id',
        'agreement_id',
        'refund'
    ];
}
