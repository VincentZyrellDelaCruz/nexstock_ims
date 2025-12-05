<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('alerts.index', compact('alerts'));
    }

    public function markAsRead(Alert $alert)
    {
        if ($alert->user_id === Auth::id()) {
            $alert->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'Alert marked as read');
    }

    public function markAllAsRead()
    {
        Alert::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->update([
                'status' => 'read',
                'read_at' => now(),
            ]);

        return back()->with('success', 'All alerts marked as read');
    }

    public function unreadCount()
    {
        $count = Alert::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        return response()->json(['count' => $count]);
    }
}

