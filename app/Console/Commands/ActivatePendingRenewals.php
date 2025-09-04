<?php

namespace App\Console\Commands;

use App\Services\MembershipRenewalService;
use Illuminate\Console\Command;

class ActivatePendingRenewals extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'membership:activate-renewals';

    /**
     * The console command description.
     */
    protected $description = 'Activate pending membership renewals that are ready';

    /**
     * Execute the console command.
     */
    public function handle(MembershipRenewalService $renewalService): int
    {
        $this->info('=== Starting Membership Renewal Activation ===');
        $this->info('Current server time: ' . now('UTC')->toDateTimeString() . ' (UTC)');
        $this->info('Current PHP timezone: ' . date_default_timezone_get());
        $this->info('App timezone: ' . config('app.timezone'));
        
        // Get pending renewals directly to debug
        $pendingRenewals = \App\Models\MembershipRenewal::where('status', 'pending')
            ->with(['user' => function($q) {
                $q->select('id', 'membership_expires_at');
            }])
            ->get();
            
        $this->info("\nFound {$pendingRenewals->count()} pending renewals in the database");
        
        foreach ($pendingRenewals as $index => $renewal) {
            $this->info("\nRenewal #{$renewal->id}:");
            $this->info("- Starts at: {$renewal->starts_at} (UTC)");
            $this->info("- Expires at: {$renewal->expires_at} (UTC)");
            $this->info("- User's current expiry: " . ($renewal->user->membership_expires_at ?? 'None'));
            $this->info("- Is ready for activation: " . ($renewal->isReadyForActivation() ? 'YES' : 'NO'));
            $this->info("- Should activate immediately: " . ($renewal->shouldActivateImmediately() ? 'YES' : 'NO'));
        }
        
        $this->info("\nAttempting to activate pending renewals...");
        $activated = $renewalService->activatePendingRenewals();

        if ($activated > 0) {
            $this->info("\n✅ Successfully activated {$activated} renewal(s).");
        } else {
            $this->info("\nℹ️ No renewals were ready for activation.");
        }
        
        $this->info("\n=== Renewal Activation Complete ===");
        return Command::SUCCESS;
    }
}
