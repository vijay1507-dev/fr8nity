<?php

namespace App\Notifications;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->password = Str::random(10); // Generate a random password
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $template = MailTemplate::where('name', 'profile_approval')
                               ->where('is_active', true)
                               ->first();

        if (!$template) {
            // Fallback to basic email if template not found
            return (new MailMessage)
                ->subject('Profile Approved - Login Credentials')
                ->view('emails.layouts.master', [
                    'content' => '
                        <h2>Welcome to Fr8nity!</h2>
                        <p>Hello ' . $notifiable->name . ',</p>
                        <p>Congratulations! Your Fr8nity profile has been approved.</p>
                        <p>You can now login using the following credentials:</p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                            <p style="margin: 5px 0;"><strong>Email:</strong> ' . $notifiable->email . '</p>
                            <p style="margin: 5px 0;"><strong>Password:</strong> ' . $this->password . '</p>
                        </div>
                        <p>Please change your password after your first login for security purposes.</p>
                        <div style="text-align: center; margin-top: 30px;">
                            <a href="' . route('login') . '" style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login Now</a>
                        </div>'
                ]);
        }

        // Replace variables in template
        $variables = [
            'name' => $notifiable->name,
            'email' => $notifiable->email,
            'password' => $this->password,
            'login_url' => route('login'),
        ];

        $subject = $template->subject;
        $body = $template->body;

        // Replace variables in subject and body
        foreach ($variables as $key => $value) {
            $subject = str_replace('{{'.$key.'}}', $value, $subject);
            $body = str_replace('{{'.$key.'}}', $value, $body);
        }

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.layouts.master', [
                'content' => $body
            ]);
    }

    /**
     * Get the generated password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
} 