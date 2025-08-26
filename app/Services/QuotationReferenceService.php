<?php

namespace App\Services;

use App\Models\MemberQuotation;
use App\Models\User;
use Carbon\Carbon;

class QuotationReferenceService
{
    /**
     * Generate a unique quotation reference number
     */
    public function generateReferenceNumber(string $companyName): string
    {
        // Split company name into words and create a better prefix
        $words = preg_split('/[\s,.-]+/', $companyName);
        $words = array_filter($words); // Remove empty elements
        
        if (count($words) >= 2) {
            // For multi-word company names, take first word + first few letters of second word
            $firstWord = preg_replace('/[^a-zA-Z]/', '', $words[0]);
            $secondWord = preg_replace('/[^a-zA-Z]/', '', $words[1]);
            
            // Take first 3 letters of first word + first 3 letters of second word
            $firstPart = strtoupper(substr($firstWord, 0, 3));
            $secondPart = strtoupper(substr($secondWord, 0, 3));
            
            $companyPrefix = $firstPart . $secondPart;
        } else {
            // For single word company names, take first 6 letters
            $cleanCompanyName = preg_replace('/[^a-zA-Z]/', '', $companyName);
            $companyPrefix = strtoupper(substr($cleanCompanyName, 0, 6));
        }
        
        // If company prefix is less than 6 characters, pad with first letter
        if (strlen($companyPrefix) < 6) {
            $firstLetter = substr($companyPrefix, 0, 1);
            $companyPrefix = str_pad($companyPrefix, 6, $firstLetter);
        }
        
        // Get current date in YYMM format
        $datePrefix = Carbon::now()->format('ym');
        
        // Get the next incremental number for this company and date
        $nextNumber = $this->getNextIncrementalNumber($companyPrefix, $datePrefix);
        
        return $companyPrefix . $datePrefix . $nextNumber;
    }
    
    /**
     * Get the next incremental number for a company and date combination
     */
    private function getNextIncrementalNumber(string $companyPrefix, string $datePrefix): string
    {
        // Find the last quotation reference number for this date (global sequence)
        $lastReference = MemberQuotation::where('quotation_reference_no', 'LIKE', '%' . $datePrefix . '%')
            ->orderBy('quotation_reference_no', 'desc')
            ->value('quotation_reference_no');
        
        if ($lastReference) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastReference, -2);
            $nextNumber = $lastNumber + 1;
        } else {
            // First quotation for this date
            $nextNumber = 1;
        }
        
        // Format as 2-digit number with leading zero
        return str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }
    
    /**
     * Generate reference number for a specific quotation
     */
    public function generateForQuotation(MemberQuotation $quotation): string
    {
        // Get company name from the given_by user (the company giving the quotation)
        $companyName = $quotation->givenBy->company_name ?? 'Unknown';
        
        return $this->generateReferenceNumber($companyName);
    }
}
