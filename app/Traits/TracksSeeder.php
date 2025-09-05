<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TracksSeeder
{
    public function callAndTrack($class)
    {
        // If tracking table doesn't exist, just run the seeder normally
        if (!Schema::hasTable('seeder_history')) {
            return $this->call($class);
        }

        // Check if seeder was already run
        if ($this->wasSeederRun($class) && !$this->command->option('force')) {
            $this->command->info("Skipping {$class} - already seeded.");
            return;
        }

        // Run the seeder
        $this->call($class);

        // Record successful run
        $this->recordSeederRun($class);
        
        $this->command->info("Seeded: {$class}");
    }

    private function wasSeederRun($class): bool
    {
        return DB::table('seeder_history')
            ->where('seeder', $class)
            ->exists();
    }

    private function recordSeederRun($class): void
    {
        $batch = DB::table('seeder_history')->max('batch') + 1;

        DB::table('seeder_history')->updateOrInsert(
            ['seeder' => $class],
            [
                'batch' => $batch,
                'seeded_at' => utcNow()
            ]
        );
    }
} 