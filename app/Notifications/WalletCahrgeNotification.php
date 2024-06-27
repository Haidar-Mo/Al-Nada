<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalletCahrgeNotification extends Notification
{
    use Queueable;

    private $charge;
    /**
     * Create a new notification instance.
     */
    public function __construct($charge)
    {
        $this->charge = $charge;
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
        return 'charge-wallet';
    }

    /**
     * Get the Database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => $this->charge->transaction_type,
            'amount' => $this->charge->amount,
            'message' => 'تم إطلاق حملة جديدة',
            'url' => url('mobile/wallet/billing-history')
        ];
    }
}
