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


    /**
     * List all notifications order by time
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $is_read = $request->input('is_read');

        $query = auth()->user()->notifications()
            ->latest();

        if ($is_read) {
            if ($is_read == 1) {
                $query->where('read_at', '!=', null);
            } else {
                $query->where('read_at', null);
            }
        }
        $notifications  = $query->paginate($perPage);
        return response()->json($notifications);
    }

    /**
     * List todat's Notifications 
     * @return JsonResponse 
     */
    public function getTodayNotifications(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $is_read = $request->input('is_read');

        $query = auth()->user()->notifications()
            ->latest();

        if ($is_read) {
            if ($is_read == 1) {
                $query->where('read_at', '!=', null);
            } else {
                $query->where('read_at', null);
            }
        }
        $notifications  = $query->whereDate('created_at', today())->paginate($perPage);
        return response()->json($notifications);
    }

    /**
     * List Unread notifiactions
     * @return JsonResponse
     */
    public function getUnreadNotifications(Request $request)
    {
        $perPage = $request->input('per_page');
        $notification = auth()->user()->notifications()
            ->where('read_at', null)
            ->latest()
            ->paginate($perPage);
        return response()->json($notification, 200);
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
