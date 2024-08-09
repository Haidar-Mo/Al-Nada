<?php

namespace App\Console\Commands;

use App\Models\SponsorshipPaymentCase;
use App\Notifications\Mobile\SponsorshipPaymentAlert;
use App\Traits\NotificationTrait;
use Illuminate\Console\Command;

class SendSponsorshipAlerts extends Command
{
    use NotificationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-sponsorship-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Alert to each User has unpaid sponsorship case';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unpaid_cases = SponsorshipPaymentCase::with('case.sponsorshipable')->where('paid', 0)->get();

        foreach ($unpaid_cases as $case) {
            $user = $case->case->sponsorshipable->user;
            $this->sendNotification($user->deviceToken, 'تذكير بدفع الكفالة', 'شكراً لك على ما تقدمه :) \n الكفالة الحالة رقم' . $case->id . 'ما زالت غير مدفوعة');
            $user->notify(new SponsorshipPaymentAlert($case));
        }
    }
}
