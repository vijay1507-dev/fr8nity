<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\TracksSeeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    use TracksSeeder;

    /**
     * Get list of custom seeders
     */
    protected function getCustomSeeders(): array
    {
        $customPath = database_path('seeders/custom');
        if (!File::exists($customPath)) {
            return [];
        }

        $files = File::files($customPath);
        $seeders = [];

        foreach ($files as $file) {
            $className = 'Database\\Seeders\\Custom\\' . $file->getBasename('.php');
            if (class_exists($className)) {
                $seeders[] = $className;
            }
        }

        return $seeders;
    }

    public function run()
    {
        // Get all custom seeders
        $seeders = $this->getCustomSeeders();

        // Run each seeder
        foreach ($seeders as $seeder) {
            $this->callAndTrack($seeder);
        }
    }
}
