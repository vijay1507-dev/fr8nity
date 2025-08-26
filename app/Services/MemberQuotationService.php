<?php

namespace App\Services;

use App\Models\MemberQuotation;
use App\Models\User;
use App\Notifications\QuotationNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class MemberQuotationService
{
    public function __construct(
        private readonly QuotationReferenceService $quotationReferenceService
    ) {}

    public function createAndNotify(array $validatedData, ?UploadedFile $document): MemberQuotation
    {
        if ($document) {
            $path = $document->store('quotation-documents', 'public');
            $validatedData['uploaded_document'] = $path;
        }
        
        // Generate quotation reference number
        $companyName = $this->getCompanyNameForQuotation($validatedData);
        $validatedData['quotation_reference_no'] = $this->quotationReferenceService->generateReferenceNumber($companyName);
        
        $quotation = MemberQuotation::create($validatedData);
        $admins = User::where('role', User::SUPER_ADMIN)->get();
        Notification::send($admins, new QuotationNotification($quotation, true));
        $quotation->receiver->notify(new QuotationNotification($quotation));
        Notification::route('mail', $quotation->email)
            ->notify(new QuotationNotification($quotation, false, true));

        return $quotation;
    }
    
    /**
     * Get company name for quotation reference number generation
     */
    private function getCompanyNameForQuotation(array $validatedData): string
    {
        // For offline enquiries, use the given_by company name
        if (isset($validatedData['given_by_id'])) {
            $givenBy = User::find($validatedData['given_by_id']);
            if ($givenBy && $givenBy->company_name) {
                return $givenBy->company_name;
            }
        }
        
        // Fallback to the name field if company name not available
        return $validatedData['name'] ?? 'Unknown';
    }
}


