<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipRenewal;
use App\Services\MembershipRenewalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipRenewalController extends Controller
{
    public function __construct(
        private MembershipRenewalService $renewalService
    ) {}

    /**
     * Display renewals for a member
     */
    public function index(User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        $renewals = $member->membershipRenewals()->with(['membershipTier', 'creator', 'activator'])->get();
        $pendingRenewals = $member->pendingRenewals;

        return view('dashboard.members.renewals.index', compact('member', 'renewals', 'pendingRenewals'));
    }

    /**
     * Show renewal details
     */
    public function show(User $member, MembershipRenewal $renewal)
    {
        if ($renewal->user_id !== $member->id) {
            abort(404);
        }

        return view('dashboard.members.renewals.show', compact('member', 'renewal'));
    }

    /**
     * Activate a pending renewal manually
     */
    public function activate(User $member, MembershipRenewal $renewal)
    {
        if ($renewal->user_id !== $member->id) {
            abort(404);
        }

        if ($renewal->status !== MembershipRenewal::STATUS_PENDING) {
            return redirect()->back()->with('error', 'This renewal is not pending.');
        }

        if ($this->renewalService->updateUserMembershipFromRenewal($renewal, Auth::id())) {
            return redirect()->route('members.renewals.show', [$member, $renewal])
                ->with('success', 'Membership updated successfully from renewal plan.');
        }

        return redirect()->back()->with('error', 'Failed to activate renewal.');
    }

    /**
     * Force activate a renewal (bypass date checks)
     */
    public function forceActivate(User $member, MembershipRenewal $renewal)
    {
        if ($renewal->user_id !== $member->id) {
            abort(404);
        }

        if ($renewal->status !== MembershipRenewal::STATUS_PENDING) {
            return redirect()->back()->with('error', 'This renewal is not pending.');
        }

        if ($this->renewalService->forceActivateRenewal($renewal, Auth::id())) {
            return redirect()->route('members.renewals.show', [$member, $renewal])
                ->with('success', 'Renewal force activated and membership updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to force activate renewal.');
    }

    /**
     * Cancel a pending renewal
     */
    public function cancel(Request $request, User $member, MembershipRenewal $renewal)
    {
        if ($renewal->user_id !== $member->id) {
            abort(404);
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        if ($this->renewalService->cancelRenewal($renewal, $request->cancellation_reason)) {
            return redirect()->route('members.renewals.index', $member)
                ->with('success', 'Renewal cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Failed to cancel renewal.');
    }

    /**
     * Get all pending renewals (admin view)
     */
    public function pending()
    {
        $renewals = MembershipRenewal::pending()
            ->with(['user', 'membershipTier', 'creator'])
            ->orderBy('starts_at')
            ->paginate(20);

        return view('dashboard.renewals.pending', compact('renewals'));
    }

    /**
     * Activate multiple renewals
     */
    public function activateMultiple(Request $request)
    {
        $request->validate([
            'renewal_ids' => 'required|array',
            'renewal_ids.*' => 'exists:membership_renewals,id',
        ]);

        $activated = 0;
        foreach ($request->renewal_ids as $renewalId) {
            $renewal = MembershipRenewal::find($renewalId);
            if ($renewal && $renewal->isReadyForActivation() && $renewal->activate(Auth::id())) {
                $activated++;
            }
        }

        return redirect()->back()->with('success', "Activated {$activated} renewal(s) successfully.");
    }
}
