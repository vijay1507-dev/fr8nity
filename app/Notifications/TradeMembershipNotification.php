<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TradeMember;

class TradeMembershipNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tradeMember;
    protected $isAdmin;

    public function __construct(TradeMember $tradeMember, bool $isAdmin = false)
    {
        $this->tradeMember = $tradeMember;
        $this->isAdmin = $isAdmin;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->isAdmin) {
            return (new MailMessage)
                ->subject('New Trade Membership Application')
                ->greeting('Hello Admin,')
                ->line('A new trade membership application has been received.')
                ->line('Details:')
                ->line('Name: ' . $this->tradeMember->name)
                ->line('Company: ' . $this->tradeMember->company_name)
                ->line('Email: ' . $this->tradeMember->email)
                ->line('Industry: ' . $this->tradeMember->product_industry_category)
                ->action('View Details', route('trade-members.show', $this->tradeMember))
                ->line('Please review the application and take necessary action.');
        }

        return (new MailMessage)
            ->subject('Trade Membership Application Received')
            ->greeting('Hello ' . $this->tradeMember->name . ',')
            ->line('Thank you for applying for trade membership with Fr8nity.')
            ->line('We have received your application and our team will review it shortly.')
            ->line('Application Details:')
            ->line('Company: ' . $this->tradeMember->company_name)
            ->line('Industry: ' . $this->tradeMember->product_industry_category)
            ->line('We will contact you soon regarding the status of your application.')
            ->line('If you have any questions, please don\'t hesitate to contact us.');
    }
}