<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\SendDonationAlerts::class,
        Commands\SendDonationCampaignAlerts::class,
        Commands\DeleteUnverifiedUser::class,
        Commands\DeleteDonationCampaignAlert::class,
        Commands\CheckIfOrphanStillSupported::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:delete-unverified-user')->daily();
        $schedule->command('app:delete-donation-campaign-alert')->daily();
        $schedule->command('alerts:send-donation-alerts')->daily();
        $schedule->command('alerts:send-donation-campaign-alerts')->daily();
        $schedule->command('app:check-still-supported')->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
