<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function getMembershipReminderDays(): int
    {
        return (int) Setting::get('membership_reminder_days', 15);
    }

    public function setMembershipReminderDays(int $days): void
    {
        Setting::set('membership_reminder_days', $days);
    }

    public function getSiteSettings(): array
    {
        return [
            'site_phone' => Setting::get('site_phone', ''),
            'site_email' => Setting::get('site_email', ''),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_linkedin' => Setting::get('social_linkedin', ''),
            'social_twitter' => Setting::get('social_twitter', ''),
            'social_youtube' => Setting::get('social_youtube', ''),
        ];
    }

    public function updateSiteSettings(array $data): void
    {
        Setting::set('site_phone', $data['site_phone'] ?? '');
        Setting::set('site_email', $data['site_email'] ?? '');
        Setting::set('social_facebook', $data['social_facebook'] ?? '');
        Setting::set('social_instagram', $data['social_instagram'] ?? '');
        Setting::set('social_linkedin', $data['social_linkedin'] ?? '');
        Setting::set('social_twitter', $data['social_twitter'] ?? '');
        Setting::set('social_youtube', $data['social_youtube'] ?? '');
    }
}


