<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $reminderDays = Setting::get('membership_reminder_days', 15);
        return view('dashboard.settings.index', compact('reminderDays'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'membership_reminder_days' => 'required|integer|min:1|max:90'
        ]);

        Setting::set('membership_reminder_days', $request->membership_reminder_days);

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully');
    }
}