<?php

namespace App\Notifications\Mobile;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalletChargeNotification extends Notification
{
    use Queueable;

    protected $charge, $amount;
    /**
     * Create a new notification instance.
     */
    public function __construct($charge, $amount)
    {
        $this->charge = $charge;
        $this->amount = $amount;
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
        return get_class($this->charge);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'تم شحن حسابك بمبلغ وقدره' . $this->amount,
            'url' => route('mobile.charge.show', $this->charge->id)
        ];
    }

    
}
