<?php

namespace App\Mail;

use App\Models\User;
use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRegistrationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $template = MailTemplate::where('name', 'new_registration')
                               ->where('is_active', true)
                               ->first();

        $parsed = $template->parseTemplate([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'company_name' => $this->user->company_name,
            'registration_date' => $this->user->created_at->format('Y-m-d H:i:s'),
        ]);

        return $this->subject($parsed['subject'])
                   ->view('emails.layouts.master')
                   ->with([
                       'subject' => $parsed['subject'],
                       'content' => $parsed['body']
                   ]);
    }
} 