<?php

namespace App\Console\Commands;

use App\Models\DonationCampaignAlert;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDonationCampaignAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:send-donation-campaign-alerts';

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
        $dailyAlerts = DonationCampaignAlert::where('frequency', 'يومي')->get();
        $weeklyAlerts = DonationCampaignAlert::where('frequency', 'اسبوعي')->whereDay('created_at', $now->dayOfWeek)->get();
        $monthlyAlerts = DonationCampaignAlert::where('frequency', 'شهري')->whereDay('created_at', $now->day)->get();

        $alerts = $dailyAlerts->merge($weeklyAlerts)->merge($monthlyAlerts);

        $notification = new NotificationService;
        foreach ($alerts as $alert) {
            $user = User::find($alert->user_id);
            if ($user) {
                $notification->sendNotification($user->deviceToken, 'تذكير', "$alert->title");
            }
        }

        $this->info('Donation alerts sent successfully.');
    }
}
