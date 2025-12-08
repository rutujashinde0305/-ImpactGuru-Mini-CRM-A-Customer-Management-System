<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxNotificationController extends Controller
{
    /**
     * Return unread notifications for the authenticated user as JSON.
     */
    public function unreadJson(Request $request)
    {
        $user = $request->user();

        $notifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'type' => class_basename($n->type),
                    'data' => $n->data,
                    'created_at' => $n->created_at->toDateTimeString(),
                    'diff' => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json([ 'success' => true, 'data' => $notifications ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Request $request, $id)
    {
        $user = $request->user();

        $notification = $user->notifications()->where('id', $id)->first();
        if (! $notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}
