<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of Notification.
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(5);
        return response()->json($notifications, 200);
    }

    /**
     * Marke the specified notification as read.
     * @return JsonResponse
     */
    public function markAsRead(string $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->find($id);
        $notification->markAsRead();
        $notification->save();
        return response()->json($notification, 200);
    }

    /**
     * Mark the specific notificatoin as unRead
     * @return JsonResponse
     */
    public function markAsUnRead(string $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->find($id);
        $notification->markAsUnRead();
        $notification->save();
        return response()->json($notification, 200);
    }

    /**
     * Mark all notifications as read.
     * @return JsonResponse
     */
    public function markAllAsRead()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications->markAsRead();
        return response()->json($notifications, 200);
    }

    /**
     * Remove the specified Notification from storage.
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->find($id);
        $notification->delete();
        return response()->json(null, 204);
    }
}
