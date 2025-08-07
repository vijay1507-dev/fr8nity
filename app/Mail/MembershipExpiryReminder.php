<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipExpiryReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $daysUntilExpiry;
    public $subject;

    public function __construct(User $user, int $daysUntilExpiry)
    {
        $this->user = $user;
        $this->daysUntilExpiry = $daysUntilExpiry;
        $this->subject = 'Membership Expiry Reminder - Fr8nity';
    }

    public function build()
    {
        $content = view('emails.membership-expiry-reminder', [
            'user' => $this->user,
            'daysUntilExpiry' => $this->daysUntilExpiry
        ])->render();

        return $this->view('emails.layouts.master', [
            'subject' => $this->subject,
            'content' => $content
        ])->subject($this->subject);
    }
}