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
}