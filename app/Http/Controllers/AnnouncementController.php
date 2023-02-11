<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnnouncementRead;

class AnnouncementController extends Controller
{
    public function index()
    {

        return view('announcement.index');
    }

    public function show(Request $request, Announcement $announcement)
    {

        $user = $request->user();
        $announcement_read = AnnouncementRead::where('user_id', $user->id)
            ->where('announcement_id', $announcement->id)
            ->first();

        if (!is_null($announcement_read)) {

            $announcement_read->read = true;
            $announcement_read->save();
        }

        return $announcement;
    }

    public function list(Request $request)
    {
        $user = $request->user();

        return Announcement::whereDoesntHave('reads', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->orWhere(function ($query) use ($user) {
                $query->whereHas('reads', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('read', false);
                });
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(7);
    }

}
