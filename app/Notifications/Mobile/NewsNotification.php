<?php

namespace App\Notifications\Mobile;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsNotification extends Notification
{
    use Queueable;

    protected $news;
    /**
     * Create a new notification instance.
     */
    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return get_class($this->news);
    }

    /**
     * Get the Database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'ما الجديد في جمعية الندى ؟',
            'url' => route('mobile.news.show', $this->news->id)
        ];
    }
}
