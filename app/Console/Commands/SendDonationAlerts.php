<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\DonationAlert;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Traits\NotificationTrait;

class SendDonationAlerts extends Command
{
    use NotificationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:send-donation-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send donation alerts to users based on their alert frequency';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Get alerts for today based on the frequency
        $dailyAlerts = DonationAlert::where('frequency', 'يومي')->get();
        $weeklyAlerts = DonationAlert::where('frequency', 'اسبوعي')->whereDay('created_at', $now->dayOfWeek)->get();
        $monthlyAlerts = DonationAlert::where('frequency', 'شهري')->whereDay('created_at', $now->day)->get();

        $alerts = $dailyAlerts->merge($weeklyAlerts)->merge($monthlyAlerts);


        foreach ($alerts as $alert) {
            $user = User::find($alert->user_id);
            if ($user) {
                $this->sendNotification($user->deviceToken, 'تذكير', "$alert->title");
            }
        }

        $this->info('Donation alerts sent successfully.');
    }
}
