<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\MailTemplate;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getRenewalDaysPriorExpiring(): int
    {
        return (int) Setting::get('renewal_days_prior_expiring', 30);
    }

    public function setRenewalDaysPriorExpiring(int $days): void
    {
        Setting::set('renewal_days_prior_expiring', $days);
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

    // Email Template Management Methods
    public function getEmailTemplates(int $perPage = 10): LengthAwarePaginator
    {
        return MailTemplate::paginate($perPage);
    }

    public function getEmailTemplate(int $id): ?MailTemplate
    {
        return MailTemplate::find($id);
    }

    public function createEmailTemplate(array $data): MailTemplate
    {
        return MailTemplate::create([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'comment' => $data['comment'] ?? null,
            'variables' => $data['variables'] ?? [],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function updateEmailTemplate(MailTemplate $template, array $data): bool
    {
        return $template->update([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'comment' => $data['comment'] ?? null,
            'variables' => $data['variables'] ?? [],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function deleteEmailTemplate(MailTemplate $template): bool
    {
        return $template->delete();
    }

    public function toggleEmailTemplateStatus(MailTemplate $template): bool
    {
        return $template->update(['is_active' => !$template->is_active]);
    }

    public function getActiveEmailTemplates(): \Illuminate\Database\Eloquent\Collection
    {
        return MailTemplate::where('is_active', true)->get();
    }
}


