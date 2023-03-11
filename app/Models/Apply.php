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
        'host_user',
        'apply_user_id',
        'first_chat',
        'status'
    ];
    public function hotaru_request()
    {
        return $this->belongsTo(HotaruRequest::class, 'request_id');
    }

}
