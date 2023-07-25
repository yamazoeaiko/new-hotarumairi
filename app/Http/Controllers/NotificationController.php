<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\RegisterCompleted;
use Notifiable;

class NotificationController extends Controller
{
    public function getRegisterComplete(){
        $user = Auth::user();
        $userName = $user->nickname;

        $user->notify(new RegisterCompleted($userName));

        return view('auth.register_complete');
    }
}
