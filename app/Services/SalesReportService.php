<?php

namespace App\Services;

use App\Models\User;
use App\Models\MemberQuotation;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SalesReportService
{
    /**
     * Get all members for dropdown
     */
    public function getMembers(): Collection
    {
        return User::where('role', User::MEMBER)
            ->select('id', 'name', 'company_name')
            ->orderBy('name')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'display_name' => $member->name . ' - ' . $member->company_name
                ];
            });
    }

    /**
     * Get all quotations for a member within date range (both given and received)
     */
    public function getAllQuotations(int $memberId, ?string $dateFrom = null, ?string $dateTo = null): Collection
    {
        $query = MemberQuotation::with(['receiver', 'givenBy', 'portOfLoading', 'portOfDischarge'])
            ->where(function ($q) use ($memberId) {
                $q->where('receiver_id', $memberId)
                  ->orWhere('given_by_id', $memberId);
            });

        // Apply date filters if provided
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get successful quotations for a member within date range
     */
    public function getSuccessfulQuotations(int $memberId, ?string $dateFrom = null, ?string $dateTo = null): Collection
    {
        $query = MemberQuotation::with(['receiver', 'givenBy', 'portOfLoading', 'portOfDischarge'])
            ->where(function ($q) use ($memberId) {
                $q->where('receiver_id', $memberId)
                  ->orWhere('given_by_id', $memberId);
            })
            ->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL); // Only successful quotations

        // Apply date filters if provided
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get successful quotations for all members within date range
     */
    public function getAllMembersSuccessfulQuotations(?string $dateFrom = null, ?string $dateTo = null): Collection
    {
        $query = MemberQuotation::with(['receiver', 'givenBy', 'portOfLoading', 'portOfDischarge'])
            ->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL); // Only successful quotations

        // Apply date filters if provided
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Generate CSV data from quotations
     */
    public function generateCsvData(Collection $quotations, ?User $member = null): string
    {
        // CSV Headers
        $headers = [
            'Date',
            'Quotation ID',
            'Role',
            'Giver Name',
            'Giver Company',
            'Receiver Name',
            'Receiver Company',
            'Port of Loading',
            'Port of Discharge',
            'Transaction Value',
            'Status',
            'Contact Name',
            'Contact Phone',
            'Contact Email',
            'Message'
        ];

        $csvData = implode(',', array_map([$this, 'escapeCsvValue'], $headers)) . "\n";

        // CSV Data rows
        foreach ($quotations as $quotation) {
            // Determine role based on whether we have a specific member or all members
            $role = $member ? 
                ($quotation->receiver_id == $member->id ? 'Receiver' : 'Giver') : 
                'Both';
            
            $row = [
                $quotation->created_at->format('Y-m-d'),
                $quotation->id,
                $role,
                $quotation->givenBy->name ?? 'N/A',
                $quotation->givenBy->company_name ?? 'N/A',
                $quotation->receiver->name ?? 'N/A',
                $quotation->receiver->company_name ?? 'N/A',
                $quotation->portOfLoading->name ?? 'N/A',
                $quotation->portOfDischarge->name ?? 'N/A',
                $quotation->transaction_value ?? 'N/A',
                $quotation->getStatusLabel(),
                $quotation->name ?? 'N/A',
                $quotation->phone ?? 'N/A',
                $quotation->email ?? 'N/A',
                $quotation->message ?? 'N/A'
            ];

            $csvData .= implode(',', array_map([$this, 'escapeCsvValue'], $row)) . "\n";
        }

        return $csvData;
    }

    /**
     * Generate CSV data for all quotations (including all statuses)
     */
    public function generateAllQuotationsCsvData(Collection $quotations, ?User $member = null): string
    {
        // CSV Headers
        $headers = [
            'Date',
            'Role',
            'Giver Name',
            'Giver Company',
            'Receiver Name',
            'Receiver Company',
            'Port of Loading',
            'Port of Discharge',
            'Transaction Value',
            'Status',
            'Contact Name',
            'Contact Phone',
            'Contact Email',
            'Message'
        ];

        $csvData = implode(',', array_map([$this, 'escapeCsvValue'], $headers)) . "\n";

        // CSV Data rows
        foreach ($quotations as $quotation) {
            // Determine role based on whether we have a specific member or all members
            $role = $member ? 
                ($quotation->receiver_id == $member->id ? 'Receiver' : 'Giver') : 
                'Both';
            
            $row = [
                $quotation->created_at->format('Y-m-d'),
                $role,
                $quotation->givenBy->name ?? 'N/A',
                $quotation->givenBy->company_name ?? 'N/A',
                $quotation->receiver->name ?? 'N/A',
                $quotation->receiver->company_name ?? 'N/A',
                $quotation->portOfLoading->name ?? 'N/A',
                $quotation->portOfDischarge->name ?? 'N/A',
                $quotation->transaction_value ?? 'N/A',
                $quotation->getStatusLabel(),
                $quotation->name ?? 'N/A',
                $quotation->phone ?? 'N/A',
                $quotation->email ?? 'N/A',
                $quotation->message ?? 'N/A'
            ];

            $csvData .= implode(',', array_map([$this, 'escapeCsvValue'], $row)) . "\n";
        }

        return $csvData;
    }

    /**
     * Generate CSV data for all members with proper header
     */
    public function generateAllMembersCsvData(Collection $quotations, ?string $dateFrom = null, ?string $dateTo = null): string
    {
        $csvData = "";
        if ($dateFrom || $dateTo) {
            $csvData .= "Date Range: ";
            if ($dateFrom && $dateTo) {
                $csvData .= "From {$dateFrom} to {$dateTo}\n";
            } elseif ($dateFrom) {
                $csvData .= "From {$dateFrom}\n";
            } elseif ($dateTo) {
                $csvData .= "Until {$dateTo}\n";
            }
        }

        // CSV Headers
        $headers = [
            'Date',
            'Quotation ID',
            'Giver Name',
            'Giver Company',
            'Receiver Name',
            'Receiver Company',
            'Port of Loading',
            'Port of Discharge',
            'Transaction Value',
            'Status',
            'Contact Name',
            'Contact Phone',
            'Contact Email',
            'Message'
        ];

        $csvData .= implode(',', array_map([$this, 'escapeCsvValue'], $headers)) . "\n";

        // CSV Data rows
        foreach ($quotations as $quotation) {
            $row = [
                $quotation->created_at->format('Y-m-d'),
                $quotation->id,
                $quotation->givenBy->name ?? 'N/A',
                $quotation->givenBy->company_name ?? 'N/A',
                $quotation->receiver->name ?? 'N/A',
                $quotation->receiver->company_name ?? 'N/A',
                $quotation->portOfLoading->name ?? 'N/A',
                $quotation->portOfDischarge->name ?? 'N/A',
                $quotation->transaction_value ?? 'N/A',
                $quotation->getStatusLabel(),
                $quotation->name ?? 'N/A',
                $quotation->phone ?? 'N/A',
                $quotation->email ?? 'N/A',
                $quotation->message ?? 'N/A'
            ];

            $csvData .= implode(',', array_map([$this, 'escapeCsvValue'], $row)) . "\n";
        }

        return $csvData;
    }

    /**
     * Generate filename for CSV export
     */
    public function generateFilename(User $member): string
    {
        return 'successful_sales_report_' . str_replace(' ', '_', strtolower($member->name)) . '_' . now()->format('Y_m_d_H_i_s') . '.csv';
    }

    /**
     * Generate filename for all quotations CSV export
     */
    public function generateAllQuotationsFilename(User $member): string
    {
        return 'all_quotations_report_' . str_replace(' ', '_', strtolower($member->name)) . '_' . now()->format('Y_m_d_H_i_s') . '.csv';
    }

    /**
     * Generate filename for all members CSV export
     */
    public function generateAllMembersFilename(?string $dateFrom = null, ?string $dateTo = null): string
    {
        $filename = 'all_members_successful_sales_report_' . now()->format('Y_m_d_H_i_s');
        
        if ($dateFrom && $dateTo) {
            $filename .= '_' . $dateFrom . '_to_' . $dateTo;
        } elseif ($dateFrom) {
            $filename .= '_from_' . $dateFrom;
        } elseif ($dateTo) {
            $filename .= '_until_' . $dateTo;
        }
        
        return $filename . '.csv';
    }

    /**
     * Escape CSV values to handle commas, quotes, and newlines
     */
    private function escapeCsvValue($value): string
    {
        // Convert null to empty string
        if ($value === null) {
            $value = '';
        }

        // Convert to string
        $value = (string) $value;

        // Remove newlines and carriage returns
        $value = str_replace(["\r\n", "\r", "\n"], ' ', $value);

        // If value contains comma, quote, or starts with space, wrap in quotes
        if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, ' ') === 0) {
            // Escape existing quotes by doubling them
            $value = str_replace('"', '""', $value);
            $value = '"' . $value . '"';
        }

        return $value;
    }

    /**
     * Get member details by ID
     */
    public function getMember(int $memberId): User
    {
        return User::findOrFail($memberId);
    }

    /**
     * Check if quotations exist for the given criteria
     */
    public function hasQuotations(Collection $quotations): bool
    {
        return $quotations->isNotEmpty();
    }

    /**
     * Get quotation statistics for a member
     */
    public function getQuotationStats(int $memberId, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $quotations = $this->getAllQuotations($memberId, $dateFrom, $dateTo);
        
        $stats = [
            'total_quotations' => $quotations->count(),
            'given_quotations' => $quotations->where('given_by_id', $memberId)->count(),
            'received_quotations' => $quotations->where('receiver_id', $memberId)->count(),
            'successful_quotations' => $quotations->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->count(),
            'unsuccessful_quotations' => $quotations->where('status', MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL)->count(),
            'total_value' => $quotations->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL)->sum('transaction_value'),
            'pending_quotations' => $quotations->whereNotIn('status', [MemberQuotation::STATUS_CLOSED_SUCCESSFUL, MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL])->count()
        ];

        return $stats;
    }

    /**
     * Get report summary data
     */
    public function getReportSummary(Collection $quotations, User $member, ?string $dateFrom, ?string $dateTo): array
    {
        $totalValue = $quotations->sum('transaction_value');
        $giverCount = $quotations->where('given_by_id', $member->id)->count();
        $receiverCount = $quotations->where('receiver_id', $member->id)->count();

        return [
            'total_transactions' => $quotations->count(),
            'total_value' => $totalValue,
            'giver_transactions' => $giverCount,
            'receiver_transactions' => $receiverCount,
            'date_range' => [
                'from' => $dateFrom,
                'to' => $dateTo
            ],
            'member' => [
                'name' => $member->name,
                'company' => $member->company_name
            ]
        ];
    }
}
