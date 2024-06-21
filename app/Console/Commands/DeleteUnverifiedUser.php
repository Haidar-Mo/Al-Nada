<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnverifiedUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users that are not verified yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();

        User::whereNull('email_verified_at')->where('created_at', '<', $oneWeekAgo)->delete();
        $this->info('Unverified Users deleted successfully');
    }
}
