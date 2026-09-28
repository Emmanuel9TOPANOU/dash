<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::forUser(Auth::id())
            ->where('is_read', false)
            ->latest()
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'items' => $notifications->map(fn($notification) => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'link' => $notification->link,
                'is_read' => (bool) $notification->is_read,
                'created_at' => $notification->created_at?->diffForHumans(),
            ])->values(),
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        Notification::forUser(Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAsRead(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
