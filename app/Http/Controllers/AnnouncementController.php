<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function listing()
    {

        $announcements = Announcement::active()->orderBy('id', 'desc')->paginate();
        return view('welcome', compact('announcements'));
    }
}
