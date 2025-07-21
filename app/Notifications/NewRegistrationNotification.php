<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $template = MailTemplate::where('name', 'new_registration')
                               ->where('is_active', true)
                               ->first();

        if (!$template) {
            // Fallback to basic email if template not found
            return (new MailMessage)
                ->subject('New User Registration: ' . $this->user->name)
                ->greeting('Hello Admin')
                ->line('A new user has registered on the platform.')
                ->line('Name: ' . $this->user->name)
                ->line('Email: ' . $this->user->email)
                ->line('Company: ' . $this->user->company_name)
                ->line('Please review their application.');
        }

        // Replace variables in template
        $variables = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'company_name' => $this->user->company_name,
            'designation' => $this->user->designation,
            'company_telephone' => $this->user->company_telephone,
            'whatsapp_phone' => $this->user->whatsapp_phone,
            'company_address' => $this->user->company_address,
            'membership_tier' => $this->user->membership_tier,
            'registration_date' => now()->format('Y-m-d H:i:s')
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'company_name' => $this->user->company_name
        ];
    }
} 