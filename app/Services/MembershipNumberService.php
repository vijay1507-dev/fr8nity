<?php

namespace App\Services;

use App\Models\MembershipTier;
use App\Models\User;

class MembershipNumberService
{
    public function generateForTierId(int $membershipTierId): string
    {
        $membershipTier = MembershipTier::findOrFail($membershipTierId);

        $prefix = MembershipTier::MEMBERSHIP_NUMBER_PREFIXES[$membershipTier->slug] ?? '';

        $lastNumber = User::whereNotNull('membership_number')
            ->orderByRaw('CAST(SUBSTRING(membership_number, -3) AS UNSIGNED) DESC')
            ->value('membership_number');

        if ($lastNumber) {
            $lastSequence = (int) substr($lastNumber, -3);
            $newSequence = str_pad((string) ($lastSequence + 1), 3, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '001';
        }

        return $prefix . $newSequence;
    }

    /**
     * Update existing membership number when tier changes
     * Keeps the sequence number but updates the tier prefix
     */
    public function updateForTierChange(string $existingMembershipNumber, int $newTierId): string
    {
        $membershipTier = MembershipTier::findOrFail($newTierId);
        $newPrefix = MembershipTier::MEMBERSHIP_NUMBER_PREFIXES[$membershipTier->slug] ?? '';
        
        // Extract the sequence number from the existing membership number
        // Expected format: F8XXX08050 + 3-digit sequence (e.g., F8EXP08050002)
        $sequence = substr($existingMembershipNumber, -3);
        
        // Validate that the sequence is numeric and has exactly 3 digits
        if (!is_numeric($sequence) || strlen($sequence) !== 3) {
            // If the existing number doesn't follow the expected format, generate a new one
            return $this->generateForTierId($newTierId);
        }
        
        // Ensure the sequence is properly zero-padded
        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);
        
        return $newPrefix . $sequence;
    }
}


