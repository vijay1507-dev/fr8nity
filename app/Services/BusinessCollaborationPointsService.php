<?php

namespace App\Services;

use App\Models\User;
use App\Models\MemberQuotation;
use App\Models\MembershipTierReward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BusinessCollaborationPointsService
{
    /**
     * Allocate points to quotation giver based on transaction value and membership tier
     */
    public function allocatePointsForQuotationSuccess(MemberQuotation $quotation): bool
    {
        try {
            // Get the quotation giver
            $giver = $quotation->givenBy;
            
            if (!$giver || !$giver->membershipTier) {
                Log::warning('Cannot allocate points: Giver not found or has no membership tier', [
                    'quotation_id' => $quotation->id,
                    'giver_id' => $quotation->given_by_id
                ]);
                return false;
            }

            // Calculate points based on transaction value and tier using database configuration
            $points = $this->calculatePoints($quotation->transaction_value, $giver->membershipTier->id);
            
            if ($points <= 0) {
                Log::info('No points to allocate for transaction value', [
                    'quotation_id' => $quotation->id,
                    'transaction_value' => $quotation->transaction_value,
                    'tier' => $giver->membershipTier->name
                ]);
                return false;
            }

            // Create reward points entry
            DB::table('reward_points')->insert([
                'user_id' => $giver->id,
                'activity_type' => 'business_collaboration',
                'points' => $points,
                'description' => "Business collaboration points for successful quotation (Ref: {$quotation->quotation_reference_no}, Value: USD {$quotation->transaction_value})",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Business collaboration points allocated successfully', [
                'quotation_id' => $quotation->id,
                'giver_id' => $giver->id,
                'points' => $points,
                'transaction_value' => $quotation->transaction_value,
                'tier' => $giver->membershipTier->name
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to allocate business collaboration points', [
                'quotation_id' => $quotation->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Calculate points based on transaction value and membership tier using database configuration
     */
    private function calculatePoints(float $transactionValue, int $membershipTierId): float
    {
        // Get transaction value ranges from model
        $ranges = MembershipTierReward::getBusinessCollaborationRanges();

        // Find the appropriate range for the transaction value
        foreach ($ranges as $range) {
            if ($transactionValue > $range['min'] && 
                ($range['max'] === null || $transactionValue <= $range['max'])) {
                
                // Get points from database
                $reward = MembershipTierReward::where('membership_tier_id', $membershipTierId)
                    ->where('activity_type', $range['activity_type'])
                    ->first();
                
                if ($reward) {
                    return (float) ($reward->points * $reward->multiplier);
                }
                
                Log::warning('No reward configuration found for business collaboration', [
                    'membership_tier_id' => $membershipTierId,
                    'activity_type' => $range['activity_type'],
                    'transaction_value' => $transactionValue
                ]);
                
                return 0;
            }
        }

        // If transaction value is <= 50, no points
        return 0;
    }
}
