<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    use NotificationTrait;

    public function notifyUser(Request $request)
    {
        $token = $request->device_token;
        $title = $request->title;
        $body = $request->body;
        $this->sendNotification($token, $title, $body);
        return response()->json(['message' => 'Notification sent successfully'], 200);
    }
}
