<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = Announcement::whereHas('reads', function ($query) use ($user) {

            $query->where('user_id', $user->id)
                ->where('read', false);
        })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')->get();

        return view('announcement.index', compact('items'));
    }

    public function read(Request $request)
    {
        $user_id = Auth::id();
        $announcementRead = AnnouncementRead::where('announcement_id', $request->announcement_id)->where('user_id', $user_id)->first();
        $announcementRead->read = true;
        $announcementRead->save();

        return redirect()->route($request->link_path);
    }

    //管理
    public function adminIndex()
    {
        $user = Auth::user();
        $items = Announcement::whereHas('reads', function ($query) use ($user) {

                $query->where('user_id', $user->id)
                ->where('read', false);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')->get();

        return view('admin.announcement.index', compact('items'));
    }

    public function adminRead(Request $request)
    {
        $user_id = Auth::id();
        $announcementRead = AnnouncementRead::where('announcement_id', $request->announcement_id)->where('user_id', $user_id)->first();
        $announcementRead->read = true;
        $announcementRead->save();

        return redirect()->route($request->link_path);
    }
}
