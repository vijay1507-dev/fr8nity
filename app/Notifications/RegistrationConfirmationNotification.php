<?php

namespace App\Notifications;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $template = MailTemplate::where('name', 'registration_confirmation')
                               ->where('is_active', true)
                               ->first();

        if (!$template) {
            // Fallback to basic email if template not found
            return (new MailMessage)
                ->subject('Registration Confirmation')
                ->greeting('Hello ' . $notifiable->name)
                ->line('Thank you for registering with Fr8nity.')
                ->line('Your registration request has been successfully submitted.')
                ->line('We will notify you once your application has been reviewed.');
        }

        // Replace variables in template
        $variables = [
            'name' => $notifiable->name
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
            //
        ];
    }
} 