<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    public function follow(Request $request, $follower_id)
    {
        $user = Auth::user();

        $follow = new Follow([
            'user_id' => $user->id,
            'follow_id' => $follower_id
        ]);

        $follow->save();

        return back();
    }

    public function unfollow(Request $request,$follower_id)
    {
        $user = Auth::user();
        $follow = Follow::where('follow_id', $follower_id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        $follow->delete();

        return back();
    }
}
