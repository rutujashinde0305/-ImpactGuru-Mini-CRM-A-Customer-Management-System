<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    /**
     * Display a listing of the user's notifications.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->orderBy('created_at','desc')->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read and redirect to related resource if present.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->where('id', $id)->first();
        if (! $notification) {
            return redirect()->back()->with('error','Notification not found');
        }

        $notification->markAsRead();

        $data = (array) $notification->data;
        if (!empty($data['order_id'])) {
            return redirect()->route('orders.show', $data['order_id']);
        }
        if (!empty($data['customer_id'])) {
            return redirect()->route('customers.show', $data['customer_id']);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
