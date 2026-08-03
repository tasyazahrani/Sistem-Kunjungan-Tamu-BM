<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Halaman semua notifikasi
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    // API: Mendapatkan notifikasi terbaru
    public function getLatest(Request $request)
    {
        $limit = $request->input('limit', 10);
        
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'link' => $notification->link,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at,
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'icon' => $notification->icon,
                    'color' => $notification->color,
                ];
            });

        return response()->json($notifications);
    }

    /**
     * API: Jumlah notifikasi belum dibaca
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // API: Tandai notifikasi sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    // API: Tandai semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}