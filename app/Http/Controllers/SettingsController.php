<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;
use App\Models\MailTemplate;
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

    // Email Template Management Methods
    public function emailTemplatesIndex()
    {
        $templates = $this->settingsService->getEmailTemplates();
        return view('dashboard.settings.email-templates.index', compact('templates'));
    }

    public function emailTemplatesCreate()
    {
        return view('dashboard.settings.email-templates.create');
    }

    public function emailTemplatesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:mail_templates,name',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'comment' => 'nullable|string',
            'variables' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Parse variables from string to array
        $variables = [];
        if ($request->variables) {
            $variableLines = explode("\n", $request->variables);
            foreach ($variableLines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $variables[] = $line;
                }
            }
        }

        $data = $request->all();
        $data['variables'] = $variables;
        $data['is_active'] = $request->has('is_active');

        $this->settingsService->createEmailTemplate($data);

        return redirect()->route('settings.email-templates.index')
            ->with('success', 'Email template created successfully');
    }

    public function emailTemplatesShow(MailTemplate $mailTemplate)
    {
        return view('dashboard.settings.email-templates.show', compact('mailTemplate'));
    }

    public function emailTemplatesEdit(MailTemplate $mailTemplate)
    {
        return view('dashboard.settings.email-templates.edit', compact('mailTemplate'));
    }

    public function emailTemplatesUpdate(Request $request, MailTemplate $mailTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:mail_templates,name,' . $mailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'comment' => 'nullable|string',
            'variables' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Parse variables from string to array
        $variables = [];
        if ($request->variables) {
            $variableLines = explode("\n", $request->variables);
            foreach ($variableLines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $variables[] = $line;
                }
            }
        }

        $data = $request->all();
        $data['variables'] = $variables;
        $data['is_active'] = $request->has('is_active');

        $this->settingsService->updateEmailTemplate($mailTemplate, $data);

        return redirect()->route('settings.email-templates.index')
            ->with('success', 'Email template updated successfully');
    }

    public function emailTemplatesDestroy(MailTemplate $mailTemplate)
    {
        $this->settingsService->deleteEmailTemplate($mailTemplate);

        return redirect()->route('settings.email-templates.index')
            ->with('success', 'Email template deleted successfully');
    }

    public function emailTemplatesToggleStatus(MailTemplate $mailTemplate)
    {
        $this->settingsService->toggleEmailTemplateStatus($mailTemplate);

        return redirect()->route('settings.email-templates.index')
            ->with('success', 'Email template status updated successfully');
    }
}