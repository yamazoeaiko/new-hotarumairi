<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Service;
use App\Models\User;

class FavoriteController extends Controller
{
    public function favorite(Request $request, $service_id)
    {
        $user = Auth::user();

        $favorite = new Favorite([
            'user_id' => $user->id,
            'favorite_id' => $service_id,
        ]);

        $favorite->save();

        return back();
    }

    public function unfavorite(Request $request, $service_id)
    {
        $user = Auth::user();
        $favorite = Favorite::where('favorite_id', $service_id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        if ($favorite) {
            $favorite->delete();
        }

        return back();
    }
}
