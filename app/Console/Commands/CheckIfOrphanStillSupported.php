<?php

namespace App\Console\Commands;

use App\Models\Orphan;
use Illuminate\Console\Command;

class CheckIfOrphanStillSupported extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-still-supported';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all the orphans child are under 18 y';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orphan = Orphan::all();
        $orphan->each(function ($child) {
            if ($child->birth_date < now()->subMonths(216)) {
                $child->update(['is_supported' => 0]);
            }
        });
    }
}
