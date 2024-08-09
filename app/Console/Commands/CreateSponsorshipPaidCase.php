<?php

namespace App\Console\Commands;

use App\Models\SponsorshipCase;
use Illuminate\Console\Command;

class CreateSponsorshipPaidCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-sponsorship-payment-case';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Paid case for each active sponsorship case';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sposorship_case = SponsorshipCase::where('active', 1)->get();
        foreach ($sposorship_case as $case) {
            $case->createPaidCase();
        }
        $this->info('Payment cases Created');
    }
}
