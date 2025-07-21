<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class SeedTrack extends Command
{
    protected $signature = 'db:seed-track {--list : List all seeders with their status}';

    protected $description = 'List all seeders and their execution status';

    public function handle()
    {
        if (!Schema::hasTable('seeder_history')) {
            $this->error('Seeder history table not found. Please run migrations first.');
            return 1;
        }

        $seeders = $this->getSeedersStatus();
        
        if (empty($seeders)) {
            $this->info('No seeders found in the database/seeders/custom directory.');
            return 0;
        }

        $this->table(
            ['Seeder', 'Status', 'Last Run', 'Batch'],
            $seeders
        );

        return 0;
    }

    protected function getSeedersStatus(): array
    {
        $customPath = database_path('seeders/custom');
        if (!File::exists($customPath)) {
            return [];
        }

        $seederFiles = File::files($customPath);
        if (empty($seederFiles)) {
            return [];
        }

        // Get all seeder history in one query
        $seederHistory = DB::table('seeder_history')
            ->get()
            ->keyBy('seeder');

        $seeders = [];
        foreach ($seederFiles as $file) {
            $className = 'Database\\Seeders\\Custom\\' . $file->getBasename('.php');
            
            $status = $seederHistory->get($className);
            $seeders[] = [
                $file->getBasename(),
                $status ? '✓ Seeded' : 'Pending',
                $status ? $status->seeded_at : '-',
                $status ? $status->batch : '-'
            ];
        }

        return $seeders;
    }
} 