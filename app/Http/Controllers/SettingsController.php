<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(private readonly SettingsService $settingsService)
    {
    }

    public function index()
    {
        $reminderDays = $this->settingsService->getMembershipReminderDays();
        return view('dashboard.settings.index', compact('reminderDays'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'membership_reminder_days' => 'required|integer|min:1|max:90'
        ]);

        $this->settingsService->setMembershipReminderDays((int) $request->membership_reminder_days);

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully');
    }

    public function siteIndex()
    {
        $site = $this->settingsService->getSiteSettings();
        return view('dashboard.settings.site', compact('site'));
    }

    public function siteUpdate(Request $request)
    {
        $request->validate([
            'site_phone' => ['nullable', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'site_email' => 'nullable|email|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ], [
            'site_phone.regex' => 'Please enter a valid phone number.',
        ]);

        $this->settingsService->updateSiteSettings($request->only([
            'site_phone', 'site_email', 'social_facebook', 'social_instagram', 'social_linkedin', 'social_twitter', 'social_youtube'
        ]));

        return redirect()->route('settings.site.index')
            ->with('success', 'Site settings updated successfully');
    }
}