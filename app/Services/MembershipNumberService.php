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

        $lastNumber = User::where('membership_tier', $membershipTierId)
            ->whereNotNull('membership_number')
            ->orderBy('id', 'desc')
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
        // Assuming the format is: F8XXX08050 + 3-digit sequence
        $sequence = substr($existingMembershipNumber, -3);
        
        // Validate that the sequence is numeric
        if (!is_numeric($sequence)) {
            // If the existing number doesn't follow the expected format, generate a new one
            return $this->generateForTierId($newTierId);
        }
        
        return $newPrefix . $sequence;
    }
}


