<?php

namespace App\Notifications;

use App\Models\MemberQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class QuotationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $quotation;
    protected $isAdminNotification;
    protected $isSenderNotification;

    /**
     * Create a new notification instance.
     */
    public function __construct(MemberQuotation $quotation, bool $isAdminNotification = false, bool $isSenderNotification = false)
    {
        $this->quotation = $quotation;
        $this->isAdminNotification = $isAdminNotification;
        $this->isSenderNotification = $isSenderNotification;
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

        if ($this->isSenderNotification) {
            return $this->buildSenderEmail();
        }

        return $this->buildReceiverEmail();
    }

    /**
     * Build email for admin notification
     */
    protected function buildAdminEmail(): MailMessage
    {
        $content = $this->getAdminContent();
        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => 'New Quotation Request Received'
            ]);
    }

    /**
     * Build email for receiver (member) notification
     */
    protected function buildReceiverEmail(): MailMessage
    {
        $content = $this->getReceiverContent();

        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => 'New Quotation Request Received'
            ]);
    }

    /**
     * Build email for sender notification
     */
    protected function buildSenderEmail(): MailMessage
    {
        $content = $this->getSenderContent();

        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => 'Quotation Request Confirmation'
            ]);
    }

    /**
     * Get content array for admin email
     */
    protected function getAdminContent(): array
    {
        return [
            'title' => 'New Quotation Request',
            'intro' => 'A new quotation request has been submitted with the following details:',
            'tables' => [
                [
                    'title' => 'Sender Information',
                    'data' => [
                        ['Name', $this->quotation->name],
                        ['Email', $this->quotation->email],
                        ['Phone', $this->quotation->phone],
                    ]
                ],
                [
                    'title' => 'Member Information',
                    'data' => [
                        ['Name', $this->quotation->receiver->name],
                        ['Email', $this->quotation->receiver->email],
                    ]
                ],
                !empty($this->quotation->specifications) ? [
                    'title' => 'Specifications',
                    'data' => collect($this->quotation->specifications)->map(fn($spec) => [$spec])->toArray()
                ] : null,
                [
                    'title' => 'Message',
                    'data' => [[$this->quotation->message]]
                ]
            ],
            'additional_info' => array_filter([
                $this->quotation->uploaded_document ? '<strong>Document:</strong> Attached' : null,
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'outro' => 'Please review and take necessary action.'
        ];
    }

    /**
     * Get content array for receiver email
     */
    protected function getReceiverContent(): array
    {
        return [
            'title' => 'New Quotation Request',
            'intro' => [
                'Dear ' . $this->quotation->receiver->name . ',',
                'You have received a new quotation request with the following details:'
            ],
            'tables' => [
                [
                    'title' => 'Sender Information',
                    'data' => [
                        ['Name', $this->quotation->name],
                        ['Email', $this->quotation->email],
                        ['Phone', $this->quotation->phone],
                    ]
                ],
                !empty($this->quotation->specifications) ? [
                    'title' => 'Specifications',
                    'data' => collect($this->quotation->specifications)->map(fn($spec) => [$spec])->toArray()
                ] : null,
                [
                    'title' => 'Message',
                    'data' => [[$this->quotation->message]]
                ]
            ],
            'additional_info' => array_filter([
                $this->quotation->uploaded_document ? '<strong>Document:</strong> Attached' : null,
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'action' => [
                'text' => 'View Quotation Details',
                'url' => route('login')
            ],
            'outro' => 'Please review and respond to this request at your earliest convenience.'
        ];
    }

    /**
     * Get content array for sender email
     */
    protected function getSenderContent(): array
    {
        return [
            'title' => 'Quotation Request Confirmation',
            'intro' => [
                'Dear ' . $this->quotation->name . ',',
                'Thank you for submitting your quotation request. We have received your request and it has been forwarded to ' . $this->quotation->receiver->name . '.',
                'Here is a summary of your request:'
            ],
            'tables' => array_filter([
                !empty($this->quotation->specifications) ? [
                    'title' => 'Specifications',
                    'data' => collect($this->quotation->specifications)->map(fn($spec) => [$spec])->toArray()
                ] : null,
                [
                    'title' => 'Message',
                    'data' => [[$this->quotation->message]]
                ]
            ]),
            'additional_info' => array_filter([
                $this->quotation->uploaded_document ? '<strong>Document:</strong> Attached' : null,
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'outro' => [
                'The member will review your request and contact you shortly.',
                'If you have any questions in the meantime, please don\'t hesitate to contact us.'
            ]
        ];
    }

    /**
     * Build HTML content from content array
     */
    protected function buildEmailContent(array $content): string
    {
        $html = '<h2>' . $content['title'] . '</h2>';

        // Intro
        if (is_array($content['intro'])) {
            foreach ($content['intro'] as $line) {
                $html .= '<p>' . $line . '</p>';
            }
        } else {
            $html .= '<p>' . $content['intro'] . '</p>';
        }

        // Tables
        if (!empty($content['tables'])) {
            foreach (array_filter($content['tables']) as $table) {
                $html .= '<table>';
                $html .= '<tr><th colspan="' . (count($table['data'][0]) > 1 ? '2' : '1') . '">' . $table['title'] . '</th></tr>';
                foreach ($table['data'] as $row) {
                    $html .= '<tr>';
                    if (count($row) > 1) {
                        foreach ($row as $cell) {
                            $html .= '<td>' . $cell . '</td>';
                        }
                    } else {
                        $html .= '<td>' . $row[0] . '</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</table>';
            }
        }

        // Additional Info
        if (!empty($content['additional_info'])) {
            foreach ($content['additional_info'] as $info) {
                $html .= '<p>' . $info . '</p>';
            }
        }

        // Action Button
        if (!empty($content['action'])) {
            $html .= '<p><a href="' . $content['action']['url'] . '" class="button">' . $content['action']['text'] . '</a></p>';
        }

        // Outro
        if (!empty($content['outro'])) {
            if (is_array($content['outro'])) {
                foreach ($content['outro'] as $line) {
                    $html .= '<p>' . $line . '</p>';
                }
            } else {
                $html .= '<p>' . $content['outro'] . '</p>';
            }
        }

        return $html;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'quotation_id' => $this->quotation->id,
            'name' => $this->quotation->name,
            'email' => $this->quotation->email,
            'is_admin_notification' => $this->isAdminNotification,
            'is_sender_notification' => $this->isSenderNotification,
        ];
    }
}