<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\Agreement;
use App\Models\Payment;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\AnnouncementRead;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->type !== 'admin'){
            return redirect()->route('toppage');
        }

        return view('admin.index');
    }
}
