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
}


