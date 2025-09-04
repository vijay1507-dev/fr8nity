<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('settings')->where('key', 'social_linkedin')->exists();
        if (!$exists) {
            DB::table('settings')->insert([
                'key' => 'social_linkedin',
                'value' => '',
                'type' => 'string',
                'description' => 'LinkedIn profile URL',
                'created_at' => utcNow(),
                'updated_at' => utcNow(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'social_linkedin')->delete();
    }
};


