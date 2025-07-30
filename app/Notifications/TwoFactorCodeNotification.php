<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $content = view('emails.layouts.master', [
            'subject' => 'Two Factor Authentication Code',
            'content' => view('emails.auth.two-factor-code', [
                'code' => $notifiable->two_factor_code
            ])->render()
        ])->render();

        return (new MailMessage)
            ->subject('Two Factor Authentication Code')
            ->view('emails.layouts.master', [
                'subject' => 'Two Factor Authentication Code',
                'content' => view('emails.auth.two-factor-code', [
                    'code' => $notifiable->two_factor_code
                ])->render()
            ]);
    }
} 