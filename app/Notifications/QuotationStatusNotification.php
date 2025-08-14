<?php

namespace App\Notifications;

use App\Models\MemberQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class QuotationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected MemberQuotation $quotation;
    protected string $recipientType; // admin|sender|receiver

    public function __construct(MemberQuotation $quotation, string $recipientType)
    {
        $this->quotation = $quotation;
        $this->recipientType = $recipientType;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return match ($this->recipientType) {
            'admin' => $this->buildAdminEmail(),
            'sender' => $this->buildSenderEmail(),
            default => $this->buildReceiverEmail(),
        };
    }

    protected function buildAdminEmail(): MailMessage
    {
        $content = $this->getAdminContent();

        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => $this->subjectLine(),
            ]);
    }

    protected function buildReceiverEmail(): MailMessage
    {
        $content = $this->getReceiverContent();

        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => $this->subjectLine(),
            ]);
    }

    protected function buildSenderEmail(): MailMessage
    {
        $content = $this->getSenderContent();

        return (new MailMessage)
            ->view('emails.layouts.master', [
                'content' => new HtmlString($this->buildEmailContent($content)),
                'subject' => $this->subjectLine(),
            ]);
    }

    protected function subjectLine(): string
    {
        return 'Quotation Status Updated: ' . ($this->quotation->status === MemberQuotation::STATUS_CLOSED_SUCCESSFUL
            ? 'Successful'
            : 'Closed Unsuccessful');
    }

    protected function getAdminContent(): array
    {
        return [
            'title' => 'Quotation Status Updated',
            'intro' => 'The following quotation has been updated to status: <strong>' . $this->statusLabel() . '</strong>.',
            'tables' => array_filter([
                [
                    'title' => 'Sender Information',
                    'data' => [
                        ['Name', $this->quotation->name],
                        ['Email', $this->quotation->email],
                        ['Phone', $this->quotation->phone],
                    ],
                ],
                [
                    'title' => 'Member (Receiver) Information',
                    'data' => [
                        ['Name', $this->quotation->receiver?->name],
                        ['Company', $this->quotation->receiver?->company_name],
                        ['Email', $this->quotation->receiver?->email],
                    ],
                ],
                !empty($this->quotation->specifications) ? [
                    'title' => 'Specifications',
                    'data' => collect($this->quotation->specifications)->map(fn($spec) => [$spec])->toArray(),
                ] : null,
                $this->quotation->transaction_value ? [
                    'title' => 'Transaction Value',
                    'data' => [[
                        '$' . number_format((float) $this->quotation->transaction_value, 2)
                    ]],
                ] : null,
                [
                    'title' => 'Message',
                    'data' => [[$this->quotation->message]],
                ],
            ]),
            'additional_info' => array_filter([
                $this->quotation->uploaded_document ? '<strong>Document:</strong> Attached' : null,
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'action' => [
                'text' => 'View Quotation',
                'url' => route('admin.quotations.show', $this->quotation),
            ],
            'outro' => 'Please review if any further action is required.',
        ];
    }

    protected function getReceiverContent(): array
    {
        return [
            'title' => 'Quotation ' . $this->statusLabel(),
            'intro' => [
                'Dear ' . ($this->quotation->receiver?->name ?? 'Member') . ',',
                'A quotation associated with your account has been updated to: <strong>' . $this->statusLabel() . '</strong>.',
            ],
            'tables' => array_filter([
                [
                    'title' => 'Sender Information',
                    'data' => [
                        ['Name', $this->quotation->name],
                        ['Email', $this->quotation->email],
                        ['Phone', $this->quotation->phone],
                    ],
                ],
                $this->quotation->transaction_value && $this->quotation->status === MemberQuotation::STATUS_CLOSED_SUCCESSFUL ? [
                    'title' => 'Transaction Value',
                    'data' => [[
                        '$' . number_format((float) $this->quotation->transaction_value, 2)
                    ]],
                ] : null,
            ]),
            'additional_info' => array_filter([
                $this->quotation->uploaded_document ? '<strong>Document:</strong> Attached' : null,
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'action' => [
                'text' => 'View Quotation',
                'url' => route('login'),
            ],
            'outro' => 'Please log in to view full details.',
        ];
    }

    protected function getSenderContent(): array
    {
        $successful = $this->quotation->status === MemberQuotation::STATUS_CLOSED_SUCCESSFUL;

        return [
            'title' => 'Your Quotation Request is ' . ($successful ? 'Successful' : 'Closed Unsuccessful'),
            'intro' => [
                'Dear ' . $this->quotation->name . ',',
                'Your quotation with ' . ($this->quotation->receiver?->name ?? 'the member') . ' has been marked as <strong>' . $this->statusLabel() . '</strong>.',
            ],
            'tables' => array_filter([
                $successful && $this->quotation->transaction_value ? [
                    'title' => 'Transaction Value',
                    'data' => [[
                        '$' . number_format((float) $this->quotation->transaction_value, 2)
                    ]],
                ] : null,
            ]),
            'additional_info' => array_filter([
                $this->quotation->port_of_loading_id ? '<strong>Port of Loading:</strong> ' . $this->quotation->portOfLoading->name : null,
                $this->quotation->port_of_discharge_id ? '<strong>Port of Discharge:</strong> ' . $this->quotation->portOfDischarge->name : null,
            ]),
            'outro' => $successful
                ? [
                    'Thank you for doing business with our member.',
                    'You may expect further communication from the member team as needed.',
                ]
                : [
                    'We appreciate your interest. Please feel free to reach out with new enquiries in the future.',
                ],
        ];
    }

    protected function buildEmailContent(array $content): string
    {
        $html = '<h2>' . $content['title'] . '</h2>';

        if (is_array($content['intro'])) {
            foreach ($content['intro'] as $line) {
                $html .= '<p>' . $line . '</p>';
            }
        } else {
            $html .= '<p>' . $content['intro'] . '</p>';
        }

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

        if (!empty($content['additional_info'])) {
            foreach ($content['additional_info'] as $info) {
                $html .= '<p>' . $info . '</p>';
            }
        }

        if (!empty($content['action'])) {
            $html .= '<p><a href="' . $content['action']['url'] . '" class="button">' . $content['action']['text'] . '</a></p>';
        }

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

    protected function statusLabel(): string
    {
        return $this->quotation->status === MemberQuotation::STATUS_CLOSED_SUCCESSFUL
            ? 'Successful'
            : 'Closed Unsuccessful';
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quotation_id' => $this->quotation->id,
            'status' => $this->quotation->status,
            'recipient_type' => $this->recipientType,
        ];
    }
}


