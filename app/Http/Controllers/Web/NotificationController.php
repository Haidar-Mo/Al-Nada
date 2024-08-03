<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    use NotificationTrait;


    public function index()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($notifications);
    }

    /**
     * Mark the specific Notification as read
     * @param string $id The ID of the Notification
     * @return JsonResponse
     */
    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $notification->save();
        return response()->json($notification, 200);
    }

    /**
     * Mark all Notifications 
     * @return JsonResponse
     */
    public function markAllAsRead()
    {
        $notifications = auth()->user()->unreadNotifications->markAsRead();
        return response()->json($notifications, 200);
    }

    /**
     * Send a Custom Notificcation to specific user
     * @param Request $request Device-Token , title and Body of Notification
     * @return JsonResponse
     */
    public function notifyUser(Request $request, string $id)
    {
        $request->validate([
            'device_token' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
        ]);
        $user = User::findOrfail($id);
        $token = $user->deviceToken;
        $title = $request->title;
        $body = $request->body;
        $this->sendNotification($token, $title, $body);
        return response()->json(['message' => 'Notification sent successfully'], 200);
    }
}
