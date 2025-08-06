<?php

namespace App\Notifications;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShipmentEnquiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $shipment;
    protected $isAdminNotification;

    /**
     * Create a new notification instance.
     */
    public function __construct(Shipment $shipment, bool $isAdminNotification = false)
    {
        $this->shipment = $shipment;
        $this->isAdminNotification = $isAdminNotification;
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
        if ($this->isAdminNotification) {
            return $this->buildAdminEmail();
        }

        return $this->buildCustomerEmail();
    }

    /**
     * Build email for admin notification
     */
    protected function buildAdminEmail(): MailMessage
    {
        return (new MailMessage)
            ->subject('New Shipment Enquiry Received')
            ->greeting('Hello Admin,')
            ->line('A new shipment enquiry has been received with the following details:')
            ->line('Name: ' . $this->shipment->name)
            ->line('Email: ' . $this->shipment->email)
            ->line('Phone: ' . $this->shipment->phone)
            ->line('Company: ' . $this->shipment->company_name)
            ->line('Shipment Type: ' . implode(', ', $this->shipment->shipment_type))
            ->line('Mode of Transport: ' . $this->shipment->mode_of_transport)
            ->line('From: ' . $this->shipment->pickupCity->name . ', ' . $this->shipment->pickupCountry->name)
            ->line('To: ' . $this->shipment->destinationCity->name . ', ' . $this->shipment->destinationCountry->name)
            ->line('Cargo Ready Date: ' . $this->shipment->cargo_ready_date->format('F j, Y'))
            ->line('Estimated Volume: ' . $this->shipment->estimated_volume)
            ->line('Goods Description: ' . $this->shipment->goods_description)
            ->line('Special Notes: ' . ($this->shipment->special_notes ?? 'None'))
            ->line('Delivery Remarks: ' . ($this->shipment->delivery_remark ?? 'None'))
            ->action('View Shipment Details', route('shipments.show', $this->shipment))
            ->line('Please review and take necessary action.');
    }

    /**
     * Build email for customer notification
     */
    protected function buildCustomerEmail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Shipment Enquiry Has Been Received')
            ->greeting('Hello ' . $this->shipment->name . ',')
            ->line('Thank you for submitting your shipment enquiry. We have received your request and our team will review it shortly.')
            ->line('Here is a summary of your enquiry:')
            ->line('Shipment Type: ' . implode(', ', $this->shipment->shipment_type))
            ->line('Mode of Transport: ' . $this->shipment->mode_of_transport)
            ->line('From: ' . $this->shipment->pickupCity->name . ', ' . $this->shipment->pickupCountry->name)
            ->line('To: ' . $this->shipment->destinationCity->name . ', ' . $this->shipment->destinationCountry->name)
            ->line('Cargo Ready Date: ' . $this->shipment->cargo_ready_date->format('F j, Y'))
            ->line('Estimated Volume: ' . $this->shipment->estimated_volume)
            ->line('Our team will contact you shortly with quotations and further information.')
            ->line('If you have any questions in the meantime, please don\'t hesitate to contact us.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'shipment_id' => $this->shipment->id,
            'name' => $this->shipment->name,
            'email' => $this->shipment->email,
            'is_admin_notification' => $this->isAdminNotification,
        ];
    }
}