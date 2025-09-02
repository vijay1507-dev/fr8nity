<?php

namespace App\Services;

use App\Models\User;
use App\Models\MemberQuotation;
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

            // Calculate points based on transaction value and tier
            $points = $this->calculatePoints($quotation->transaction_value, $giver->membershipTier->name);
            
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
     * Calculate points based on transaction value and membership tier
     */
    private function calculatePoints(float $transactionValue, string $tierName): float
    {
        // Points matrix with base points and tier-specific multipliers
        $pointsMatrix = [
            // >USD50 & <=USD1000
            [
                'min' => 50,
                'max' => 1000,
                'base_points' => 500,
                'multipliers' => [
                    'Explorer' => 1,
                    'Elevate' => 1.5,
                    'Summit' => 2,
                    'Pinnacle' => 2
                ]
            ],
            // >USD1000 & <=USD5000
            [
                'min' => 1000,
                'max' => 5000,
                'base_points' => 700,
                'multipliers' => [
                    'Explorer' => 1,
                    'Elevate' => 1.5,
                    'Summit' => 2,
                    'Pinnacle' => 2
                ]
            ],
            // >USD5000 & <=USD25000
            [
                'min' => 5000,
                'max' => 25000,
                'base_points' => 1000,
                'multipliers' => [
                    'Explorer' => 1,
                    'Elevate' => 1.5,
                    'Summit' => 2,
                    'Pinnacle' => 2
                ]
            ],
            // >USD25000 & <=USD100K
            [
                'min' => 25000,
                'max' => 100000,
                'base_points' => 1500,
                'multipliers' => [
                    'Explorer' => 1.5,
                    'Elevate' => 2,
                    'Summit' => 2.5,
                    'Pinnacle' => 2.5
                ]
            ],
            // Above USD100K
            [
                'min' => 100000,
                'max' => null,
                'base_points' => 2000,
                'multipliers' => [
                    'Explorer' => 2,
                    'Elevate' => 2.5,
                    'Summit' => 3,
                    'Pinnacle' => 3
                ]
            ]
        ];

        // Find the appropriate range and calculate points
        foreach ($pointsMatrix as $range) {
            if ($transactionValue > $range['min'] && 
                ($range['max'] === null || $transactionValue <= $range['max'])) {
                
                $basePoints = $range['base_points'];
                $multiplier = $range['multipliers'][$tierName] ?? 1;
                
                return $basePoints * $multiplier;
            }
        }

        // If transaction value is <= 50, no points
        return 0;
    }
}
