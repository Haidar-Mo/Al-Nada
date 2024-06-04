<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials.file'));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification(Request $request)
    {
        $deviceToken = $request->input('device_token');
        $title = $request->input('title');
        $body = $request->input('body');

        $notification = Notification::create($title, $body);
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification);

        try {
            $this->messaging->send($message);
            return response()->json(['success' => true, 'message' => 'Notification sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Firebase Notification Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send notification']);
        }
    }
    /*
    public function subscribeToTopic($deviceToken, $topic)
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials.file'));
        $messaging = $factory->createMessaging();

        try {
            $messaging->subscribeToTopic($topic, $deviceToken);
            return true;
        } catch (\Exception $e) {
            Log::error('Firebase Topic Subscription Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendNotificationToTopic($topic, $title, $body)
{
    $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials.file'));
    $messaging = $factory->createMessaging();

    $notification = Notification::create($title, $body);
    $message = CloudMessage::withTarget('topic', $topic)
        ->withNotification($notification);

    try {
        $messaging->send($message);
        return true;
    } catch (\Exception $e) {
       Log::error('Firebase Topic Notification Error: ' . $e->getMessage());
        return false;
    }
}*/

    public function subscribeToTopic(Request $request)
    {
        $deviceToken = $request->input('device_token');
        $topic = $request->input('topic');

        try {
            $this->messaging->subscribeToTopic($topic, $deviceToken);
            return response()->json(['success' => true, 'message' => 'Subscribed to topic successfully!']);
        } catch (\Exception $e) {
            Log::error('Firebase Topic Subscription Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to subscribe to topic']);
        }
    }

    public function sendNotificationToTopic(Request $request)
    {
        $topic = $request->input('topic');
        $title = $request->input('title');
        $body = $request->input('body');

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification($notification);

            $this->messaging->send($message);
            return response()->json(['success' => true, 'message' => 'Notification sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Firebase Topic Notification Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send notification']);
        }
    }
}
