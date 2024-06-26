<?php

namespace App\Console\Commands;

use App\Models\DonationCampaign;
use App\Models\DonationCampaignAlert;
use Illuminate\Console\Command;

class DeleteDonationCampaignAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-donation-campaign-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all ended campaign`s alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alerts = DonationCampaignAlert::all();
        foreach ($alerts as $alert) {
            if ($alert->campaign->end_date != null)
                $alert->delete();
        }
        $this->info('Ended Donation alerts deleted successfully.');
    }
}
