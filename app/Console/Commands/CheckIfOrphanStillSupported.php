<?php

namespace App\Console\Commands;

use App\Models\OrphanFamilyChild;
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
    protected $description = 'Remove the support from orphans if the become +18';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orphan = OrphanFamilyChild::all();
        $orphan->each(function ($child) {
            if ($child->birth_date < now()->subMonths(216)) {
                $child->update(['is_supported' => 0]);
            }
        });
    }
}
