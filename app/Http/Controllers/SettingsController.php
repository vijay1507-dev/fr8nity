<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    public function __construct(private readonly SettingsService $settingsService)
    {
    }

    public function index()
    {
        $reminderDays = $this->settingsService->getMembershipReminderDays();
        $renewalDaysPriorExpiring = $this->settingsService->getRenewalDaysPriorExpiring();
        return view('dashboard.settings.index', compact('reminderDays', 'renewalDaysPriorExpiring'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'membership_reminder_days' => 'required|integer|min:1|max:90',
            'renewal_days_prior_expiring' => 'required|integer|min:1|max:365'
        ]);

        $this->settingsService->setMembershipReminderDays((int) $request->membership_reminder_days);
        $this->settingsService->setRenewalDaysPriorExpiring((int) $request->renewal_days_prior_expiring);

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
    public function emailTemplatesIndex(Request $request)
    {
        if ($request->ajax()) {
            $query = MailTemplate::query();
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($template) {
                    $buttons = '<div class="d-inline-flex align-items-center gap-2 flex-nowrap">';
                    $buttons .= '<a href="' . route('settings.email-templates.edit', $template) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    
                    $buttons .= '<form method="POST" action="' . route('settings.email-templates.toggle-status', $template) . '" class="d-inline m-0 p-0 toggle-status-form" data-action="' . ($template->is_active ? 'deactivate' : 'activate') . '">'
                              . csrf_field()
                              . method_field('PATCH') .
                              '<button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm(\'Are you sure you want to ' . ($template->is_active ? 'deactivate' : 'activate') . ' this template?\')">' . ($template->is_active ? 'Deactivate' : 'Activate') . '</button>' .
                              '</form>';
                    
                    $buttons .= '<form action="' . route('settings.email-templates.destroy', $template) . '" method="POST" class="d-inline m-0 p-0">'
                              . csrf_field()
                              . method_field('DELETE') .
                              '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this template? This action cannot be undone.\')">Delete</button>' .
                              '</form>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->addColumn('name_with_comment', function ($template) {
                    $name = '<strong>' . e($template->name) . '</strong>';
                    if ($template->comment) {
                        $name .= '<br><small class="text-muted">' . e(\Illuminate\Support\Str::limit($template->comment, 50)) . '</small>';
                    }
                    return $name;
                })
                ->addColumn('status_badge', function ($template) {
                    return $template->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('variables_count', function ($template) {
                    if ($template->variables && count($template->variables) > 0) {
                        return '<span class="badge bg-info">' . count($template->variables) . ' vars</span>';
                    }
                    return '<span class="text-muted">None</span>';
                })
                ->addColumn('subject_truncated', function ($template) {
                    return e(\Illuminate\Support\Str::limit($template->subject, 40));
                })
                ->editColumn('updated_at', function ($template) {
                    return $template->updated_at->format('M d, Y');
                })
                ->rawColumns(['action', 'name_with_comment', 'status_badge', 'variables_count'])
                ->make(true);
        }
        
        return view('dashboard.settings.email-templates.index');
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