<?php

namespace Database\Seeders\Custom;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Template definitions
     */
    private $templates = [
        'new_registration' => [
            'subject' => 'New Registration: {{name}} from {{company_name}}',
            'body' => '
<h2>New User Registration</h2>
<p>Hello Admin,</p>
<p>A new user has registered on the platform. Below are the registration details:</p>

<strong>Personal Information:</strong>
<ul>
    <li>Full Name: {{name}}</li>
    <li>Email: {{email}}</li>
    <li>Registration Date: {{registration_date}}</li>
    <li>Membership Tier: {{membership_tier}}</li>
</ul>

<strong>Company Information:</strong>
<ul>
    <li>Company Name: {{company_name}}</li>
    <li>Designation: {{designation}}</li>
    <li>Company Phone: {{company_telephone}}</li>
    <li>WhatsApp: {{whatsapp_phone}}</li>
    <li>Company Address: {{company_address}}</li>
</ul>

<p>Please review the registration and take necessary action.</p>

<div style="margin: 30px 0; text-align: center;">
    <a href="{{ route(\'admin-login\') }}" style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Review Registration</a>
</div>

<p>Best regards,<br>Fr8nity Team</p>',
            'comment' => 'Email notification sent to admin when a new user registers',
            'variables' => [
                'name',
                'email',
                'company_name',
                'designation',
                'company_telephone',
                'whatsapp_phone',
                'company_address',
                'membership_tier',
                'registration_date'
            ]
        ],
        
        'registration_confirmation' => [
            'subject' => 'Registration Request Received - Fr8nity',
            'body' => '
<h2>Registration Request Received</h2>
<p>Dear {{name}},</p>
<p>Thank you for registering with Fr8nity.</p>
<p>Your registration request has been successfully submitted. Your application is currently under review.</p>
<p>We will notify you via email once your application has been approved.</p>
<p>Thank you for your patience.</p>',
            'comment' => 'Email sent to user when they submit registration',
            'variables' => [
                'name'
            ]
        ],
        
        'registration_approved' => [
            'subject' => 'Welcome to Fr8nity - Your Registration is Approved',
            'body' => '
<h2>Welcome to Fr8nity!</h2>
<p>Dear {{name}},</p>
<p>We are pleased to inform you that your registration has been approved. You can now access all member features.</p>
<p><a href="{{login_url}}" class="button">Login Now</a></p>',
            'comment' => 'Email notification sent to user when their registration is approved',
            'variables' => [
                'name',
                'login_url'
            ]
        ],

        'password_reset' => [
            'subject' => 'Reset Your Password',
            'body' => '
<h2>Password Reset Request</h2>
<p>Dear {{name}},</p>
<p>You have requested to reset your password. Click the button below to proceed:</p>
<p><a href="{{reset_url}}" class="button">Reset Password</a></p>
<p>If you did not request this, please ignore this email.</p>',
            'comment' => 'Email sent when user requests password reset',
            'variables' => [
                'name',
                'reset_url'
            ]
        ],
    ];

    public function run()
    {
        foreach ($this->templates as $name => $template) {
            MailTemplate::create([
                'name' => $name,
                'subject' => $template['subject'],
                'body' => $template['body'],
                'comment' => $template['comment'],
                'variables' => $template['variables'],
                'is_active' => true
            ]);
        }
    }
} 