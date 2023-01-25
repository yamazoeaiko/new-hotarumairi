<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HotaruRequest;

class Apply extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'apply_user_id',
        
    ];
    public function hotaru_request()
    {
        return $this->belongsTo(HotaruRequest::class, 'request_id');
    }

}
