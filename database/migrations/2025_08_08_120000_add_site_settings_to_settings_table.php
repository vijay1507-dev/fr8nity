<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            ['key' => 'site_phone', 'value' => '', 'type' => 'string', 'description' => 'Site contact phone number'],
            ['key' => 'site_email', 'value' => '', 'type' => 'string', 'description' => 'Site contact email address'],
            ['key' => 'social_facebook', 'value' => '', 'type' => 'string', 'description' => 'Facebook page URL'],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'string', 'description' => 'Instagram profile URL'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'string', 'description' => 'Twitter/X profile URL'],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'string', 'description' => 'YouTube channel URL'],
        ];

        foreach ($defaults as $setting) {
            $exists = DB::table('settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('settings')->insert(array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'site_phone', 'site_email', 'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube'
        ])->delete();
    }
};


