<?php

namespace App\Mail;

use App\Models\User;
use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $template = MailTemplate::where('name', 'registration_confirmation')
                               ->where('is_active', true)
                               ->first();

        $parsed = $template->parseTemplate([
            'name' => $this->user->name
        ]);

        return $this->subject($parsed['subject'])
                   ->view('emails.layouts.master')
                   ->with([
                       'subject' => $parsed['subject'],
                       'content' => $parsed['body']
                   ]);
    }
} 