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
}


