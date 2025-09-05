<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTier;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Services\MemberApprovalService;
use App\Services\MembershipNumberService;
use App\Services\MembershipLogService;
use App\Rules\UniqueCompanyInCountry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function __construct(
        private readonly MemberApprovalService $memberApprovalService,
        private readonly MembershipNumberService $membershipNumberService,
        private readonly MembershipLogService $membershipLogService,
    ) {
    }
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->where('role', User::MEMBER)->with('membershipTier')->latest();

            // Apply country filter if provided
            if ($request->filled('country')) {
                $data->whereHas('country', function ($query) use ($request) {
                    $query->where('code', $request->country); // Strict country code match
                });
                // Only show active members when country filter is applied
                $data->where('is_active', true);
            }

            // Apply no activity filter (members with 0 points)
            if ($request->filled('no_activity') && $request->no_activity == '1') {
                $data->where('status', User::STATUS_APPROVED)
                    ->where('is_active', true)
                    ->whereNotExists(function($query) {
                        $query->selectRaw(1)
                            ->from('reward_points')
                            ->whereColumn('reward_points.user_id', 'users.id')
                            ->where('reward_points.points', '>', 0);
                    });
            }

            // Apply tier filter (from dashboard)
            if ($request->filled('tier')) {
                $tier = \App\Models\MembershipTier::where('slug', $request->tier)->first();
                if ($tier) {
                    $data->where('membership_tier', $tier->id)
                         ->where('status', User::STATUS_APPROVED);
                }
            }

            // Apply status filter (from dashboard)
            if ($request->filled('status')) {
                if ($request->status === 'cancelled') {
                    $data->where('status', User::STATUS_CANCELLED);
                } elseif ($request->status === 'expired') {
                    $data->where('membership_expires_at', '<', utcNow())
                        ->where('status', '!=', User::STATUS_CANCELLED);
                }
            }

            // Apply new signups filter (from dashboard)
            if ($request->filled('new_signups') && $request->new_signups == '1') {
                $period = $request->filled('period') ? (int)$request->period : 12;
                $data->where('created_at', '>=', utcNow()->subMonths($period))
                    ->where('status', User::STATUS_APPROVED);
            }

            // Apply tier change filter (from dashboard)
            if ($request->filled('tier_change')) {
                $period = $request->filled('period') ? (int)$request->period : 12;
                $startDate = utcNow()->subMonths($period);
                
                // Get users with the most recent tier change matching the filter
                $latestTierChanges = \App\Models\MembershipLog::where('action', \App\Models\MembershipLog::ACTION_CHANGE_TIER)
                    ->where('created_at', '>=', $startDate)
                    ->whereIn('status', [\App\Models\MembershipLog::STATUS_UPGRADE, \App\Models\MembershipLog::STATUS_DOWNGRADE])
                    ->selectRaw('user_id, status, created_at')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('user_id')
                    ->map(function($userLogs) {
                        // Return only the most recent log for each user
                        return $userLogs->first();
                    });

                if ($request->tier_change === 'upgrade') {
                    $userIds = $latestTierChanges->where('status', \App\Models\MembershipLog::STATUS_UPGRADE)->pluck('user_id')->toArray();
                } elseif ($request->tier_change === 'downgrade') {
                    $userIds = $latestTierChanges->where('status', \App\Models\MembershipLog::STATUS_DOWNGRADE)->pluck('user_id')->toArray();
                }
                
                if (!empty($userIds)) {
                    $data->whereIn('id', $userIds)->where('status', User::STATUS_APPROVED);
                } else {
                    // No users found with the specified tier change, return empty result
                    $data->whereRaw('1 = 0');
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('current_tier', function($row) {
                    return $row->membershipTier->name;
                })
                ->addColumn('membership_start_at', function($row) {
                    return $row->membership_start_at ? $row->membership_start_at->format('d-m-Y') : 'N/A';
                })
                ->addColumn('membership_expires_at', function($row) {
                    return $row->membership_expires_at ? $row->membership_expires_at->format('d-m-Y') : 'N/A';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function($row) {
                    $buttons = '<div class="d-inline-flex align-items-center gap-2 flex-nowrap">';
                    $buttons .= '<a href="' . route('members.show', $row) . '" class="btn btn-sm btn-outline-primary">View</a>';
                    $buttons .= '<a href="' . route('members.edit', $row) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    $buttons .= '<form action="' . route('members.destroy', $row) . '" method="POST" class="d-inline m-0 p-0">'
                                  . csrf_field()
                                  . method_field('DELETE') .
                                  '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this member?\')">Delete</button>' .
                                  '</form>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Get country name if country filter is applied
        $countryName = null;
        if ($request->filled('country')) {
            $country = \App\Models\Country::where('code', $request->country)->first();
            $countryName = $country ? $country->name : $request->country;
        }

        // Prepare filter information for the view
        $filterInfo = [];
        if ($request->filled('tier')) {
            $tierNames = [
                'explorer' => 'Explorer',
                'elevate' => 'Elevate', 
                'summit' => 'Summit',
                'pinnacle' => 'Pinnacle'
            ];
            $filterInfo['tier'] = $tierNames[$request->tier] ?? $request->tier;
        }
        
        if ($request->filled('status')) {
            $statusNames = [
                'cancelled' => 'Cancelled Members',
                'expired' => 'Expired Members'
            ];
            $filterInfo['status'] = $statusNames[$request->status] ?? $request->status;
        }
        
        if ($request->filled('new_signups') && $request->new_signups == '1') {
            $period = $request->filled('period') ? (int)$request->period : 12;
            $periodText = $period == 3 ? '3 months' : ($period == 6 ? '6 months' : '1 year');
            $filterInfo['new_signups'] = "New Sign-ups (Last $periodText)";
        }
        
        if ($request->filled('tier_change')) {
            $period = $request->filled('period') ? (int)$request->period : 12;
            $periodText = $period == 3 ? '3 months' : ($period == 6 ? '6 months' : '1 year');
            $tierChangeNames = [
                'upgrade' => "Upgrades (Last $periodText)",
                'downgrade' => "Downgrades (Last $periodText)"
            ];
            $filterInfo['tier_change'] = $tierChangeNames[$request->tier_change] ?? $request->tier_change;
        }

        return view('dashboard.members.index', compact('countryName', 'filterInfo'));
    }

    /**
     * Show the specified member.
     */
    public function show(User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }
        $member->load(['membershipTier', 'region', 'country', 'city']);
        $membershipName = $member->membershipTier->name;
        $membershipTiers = MembershipTier::all();
        $totalPoints = $member->rewardPoints()->sum('points');
        
        // Fetch membership logs for this member
        $membershipLogs = \App\Models\MembershipLog::where('user_id', $member->id)
            ->with(['changedBy', 'membershipTier'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('dashboard.members.show', compact('member', 'membershipTiers','membershipName','totalPoints', 'membershipLogs'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        $membershipTiers = MembershipTier::all();
        return view('dashboard.members.add', compact('membershipTiers'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'designation' => ['required', 'string', 'max:255'],
            'whatsapp_phone' => ['required'],
            'company_name' => ['required', 'string', 'max:255', new UniqueCompanyInCountry()],
            'company_description' => ['nullable', 'string', 'max:2000'],
            'company_telephone' => ['required'],
            'company_address' => ['required', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'region_id' => ['required', 'exists:regions,id'],
            'referred_by' => ['nullable', 'string', 'max:255'],
            'specializations' => ['required', 'array'],
            'incorporation_date' => ['required', 'date'],
            'tax_id' => ['required', 'string', 'max:255'],
            'website_linkedin' => ['required', 'string', 'max:255'],
            'is_network_member' => ['required', 'in:yes,no'],
            'network_name' => ['required_if:is_network_member,yes', 'nullable', 'string', 'max:255'],
            'membership_tier' => ['required'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'whatsapp_phone' => $request->whatsapp_phone,
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'company_telephone' => $request->company_telephone,
            'company_address' => $request->company_address,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'referred_by' => $request->referred_by,
            'specializations' => json_encode($request->specializations),
            'incorporation_date' => $request->incorporation_date,
            'tax_id' => $request->tax_id,
            'website_linkedin' => $request->website_linkedin,
            'is_network_member' => $request->is_network_member,
            'network_name' => $request->network_name,
            'membership_tier' => $request->membership_tier,
            'role' => User::MEMBER,
            'status' => 'pending',
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('members.index')
            ->with('success', 'Member added successfully!');
    }

    /**
     * Update the specified member's status.
     */
    public function updateStatus(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        $request->validate([
            'status' => ['required', 'in:pending,approved,suspended'],
        ]);

        $this->memberApprovalService->updateStatus($member, $request->status);
        return redirect()->route('members.index')->with('success', 'Member status updated successfully.');
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }
        
        $membershipTiers = MembershipTier::all();
        
        // Fetch membership logs for this member (only for admin users)
        $membershipLogs = collect();
        if (Auth::user()->role !== User::MEMBER) {
            $membershipLogs = \App\Models\MembershipLog::where('user_id', $member->id)
                ->with(['changedBy', 'membershipTier'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('dashboard.members.edit', compact('member', 'membershipTiers', 'membershipLogs'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        // Different validation rules based on user role
        if (Auth::user()->role == User::MEMBER) {
            $rules = [
                'company_logo' => ['nullable', 'image', 'max:10240'],
                'company_description' => ['nullable', 'string', 'max:2000'],
                'profile_photo' => ['nullable', 'image', 'max:10240'],
            ];

            // Add password validation rules if password is being updated
            if ($request->filled('password')) {
                $rules['current_password'] = ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('The current password is incorrect.');
                    }
                }];
                $rules['password'] = ['required', 'confirmed', Password::defaults()];
            }

            $request->validate($rules);

            $updateData = [
                'company_description' => $request->company_description,
            ];

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $updateData['profile_photo'] = $path;
            }

            if ($request->hasFile('company_logo')) {
                $companyLogoPath = $request->file('company_logo')->store('company-logos', 'public');
                $updateData['company_logo'] = $companyLogoPath;
            }

            // Add password to update data if it's being changed
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

        } else {
            // Capture old member data for logging
            $oldMemberData = [
                'membership_tier' => $member->membership_tier,
                'membership_number' => $member->membership_number,
                'membership_expires_at' => $member->membership_expires_at,
                'membership_start_at' => $member->membership_start_at,
            ];
            // Admin validation rules - all fields required
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $member->id],
                'designation' => ['required', 'string', 'max:255'],
                'whatsapp_phone' => ['required'],
                'company_name' => ['required', 'string', 'max:255', new UniqueCompanyInCountry($member->id)],
                'company_logo' => ['nullable', 'image', 'max:10240'],
                'company_description' => ['nullable', 'string', 'max:2000'],
                'company_telephone' => ['required'],
                'company_address' => ['required', 'string'],
                'country_id' => ['required', 'exists:countries,id'],
                'city_id' => ['required', 'exists:cities,id'],
                'region_id' => ['required', 'exists:regions,id'],
                'referred_by' => ['nullable', 'string', 'max:255'],
                'specializations' => ['required', 'array'],
                'incorporation_date' => ['required', 'date'],
                'tax_id' => ['required', 'string', 'max:255'],
                'website_linkedin' => ['required', 'string', 'max:255'],
                'is_network_member' => ['required', 'in:yes,no'],
                'network_name' => ['required_if:is_network_member,yes', 'nullable', 'string', 'max:255'],
                'membership_tier' => ['required'],
                'profile_photo' => ['nullable', 'image', 'max:10240'],
                'certificate_document' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            ];

            if ($request->filled('password')) {
                $rules['password'] = ['required', 'confirmed', Password::defaults()];
            }

            $request->validate($rules);

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
            }
            if ($request->hasFile('company_logo')) {
                $companyLogoPath = $request->file('company_logo')->store('company-logos', 'public');
            }
            $certificatePath = null;
            if ($request->hasFile('certificate_document')) {
                $certificatePath = $request->file('certificate_document')->store('member-certificates', 'public');
                $updateData['certificate_document'] = $certificatePath;
                $updateData['certificate_uploaded_at'] = utcNow();
            }
            
            // Update membership number based on tier change
            $membershipNumber = $member->membership_number;
            $membershipStartAt = $member->membership_start_at;
            $membershipExpiresAt = $member->membership_expires_at;
            
            if ($request->membership_tier != $member->membership_tier) {
                // Tier changed - update prefix but keep sequence number
                if ($membershipNumber) {
                    $membershipNumber = $this->membershipNumberService->updateForTierChange($membershipNumber, (int) $request->membership_tier);
                } else {
                    // No existing number - generate new one
                    $membershipNumber = $this->membershipNumberService->generateForTierId((int) $request->membership_tier);
                }
                
                // Update membership dates only when tier changes
                $tier = MembershipTier::find($request->membership_tier);
                $membershipStartAt = utcNow();
                $membershipExpiresAt = utcNow()->addYear(); 
                if ($tier && $tier->name === 'Pinnacle') {
                    $membershipExpiresAt = utcNow()->addYears(3);
                }
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'designation' => $request->designation,
                'whatsapp_phone' => $request->whatsapp_phone,
                'company_name' => $request->company_name,
                'company_description' => $request->company_description,
                'company_telephone' => $request->company_telephone,
                'company_address' => $request->company_address,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'referred_by' => $request->referred_by,
                'specializations' => json_encode($request->specializations),
                'incorporation_date' => $request->incorporation_date,
                'tax_id' => $request->tax_id,
                'website_linkedin' => $request->website_linkedin,
                'is_network_member' => $request->is_network_member,
                'network_name' => $request->network_name,
                'membership_number' => $membershipNumber,
                'membership_tier' => $request->membership_tier,
                'membership_start_at' => $membershipStartAt,
                'membership_expires_at' => $membershipExpiresAt,
            ];
            
            if ($certificatePath) {
                $updateData['certificate_document'] = $certificatePath;
                $updateData['certificate_uploaded_at'] = utcNow();
            }

            if (isset($path)) {
                $updateData['profile_photo'] = $path;
            }
            if (isset($companyLogoPath)) {
                $updateData['company_logo'] = $companyLogoPath;
            }

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
        }

        $member->update($updateData);

        // Log membership changes if admin updated membership-related fields
        if (Auth::user()->role != User::MEMBER) {
            $newMemberData = [
                'membership_tier' => $request->membership_tier,
                'membership_number' => $membershipNumber ?? $member->membership_number,
                'membership_expires_at' => $membershipExpiresAt ?? $member->membership_expires_at,
                'membership_start_at' => $membershipStartAt ?? $member->membership_start_at,
            ];

            // Check if membership-related fields changed
            $hasChanges = false;
            foreach ($oldMemberData as $key => $oldValue) {
                // Convert dates to strings for comparison to avoid object comparison issues
                $oldVal = $oldValue instanceof \Carbon\Carbon ? $oldValue->toDateTimeString() : $oldValue;
                $newVal = $newMemberData[$key] instanceof \Carbon\Carbon ? $newMemberData[$key]->toDateTimeString() : $newMemberData[$key];
                
                if ($oldVal != $newVal) {
                    $hasChanges = true;
                    break;
                }
            }

            if ($hasChanges) {
                $this->membershipLogService->logMembershipUpdate(
                    $member,
                    $oldMemberData,
                    $newMemberData,
                    $request->input('membership_change_reason'),
                    ['updated_by_admin' => true]
                );
            }
        }

        if(Auth::user()->role == User::MEMBER){
            return redirect()->route('profile')->with('success', 'Profile updated successfully!');
        }else{
            return redirect()->route('members.show', $member)
            ->with('success', 'Member updated successfully!');
        }
    }

    /**
     * Soft delete the specified member.
     */
    public function destroy(User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }

    /**
     * Cancel membership for the specified member.
     */
    public function cancelMembership(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:1000',
        ]);

        // Update member status to cancelled and deactivate access
        $member->update([
            'status' => User::STATUS_CANCELLED,
            'cancelled_at' => utcNow(),
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_by' => Auth::id(),
            'is_active' => false, 
        ]);

        // Log the cancellation with previous membership details
        \App\Models\MembershipLog::create([
            'user_id' => $member->id,
            'action' => \App\Models\MembershipLog::ACTION_CANCELLED,
            'membership_tier_id' => $member->membership_tier,
            'previous_tier_name' => $member->membershipTier->name ?? 'N/A',
            'previous_membership_number' => $member->membership_number,
            'previous_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'previous_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'previous_expiry_date' => $member->membership_expires_at,
            'new_tier_name' => null, 
            'new_membership_number' => null, 
            'new_annual_fee' => null, 
            'new_annual_fee_currency' => null,
            'new_expiry_date' => null, 
            'status' => \App\Models\MembershipLog::STATUS_CANCELLED,
            'reason' => $request->cancellation_reason,
            'changed_by' => Auth::id(),
            'metadata' => [
                'cancelled_at' => utcNow()->toISOString(),
                'previous_is_active' => $member->is_active,
                'previous_status' => $member->status,
            ],
        ]);

        return redirect()->back()
            ->with('success', 'Membership cancelled successfully.');
    }

    /**
     * Renew membership for the specified member.
     */
    public function renewMembership(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        // Validate membership status before renewal
        if ($member->status === User::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Cannot renew pending membership. Please approve the membership first.');
        }

        // Create renewal plan instead of directly updating user
        $renewalService = app(\App\Services\MembershipRenewalService::class);
        
        try {
            $renewal = $renewalService->createRenewalPlan(
                $member,
                $request->input('renewal_reason', 'Membership renewed by admin')
            );

            return redirect()->route('members.edit', $member)
                ->with('success', 'Renewal plan created successfully. It will be activated after the current membership expires.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create renewal plan: ' . $e->getMessage());
        }
    }

    /**
     * Display the member directory.
     */
    public function directory(Request $request)
    {
        $query = User::approvedActiveMembers()
            ->with(['membershipTier', 'region', 'country', 'city'])
            ->filterForDirectory($request->only(['company_name', 'country', 'city', 'specialization']))
            ->latest();

        $members = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            $html = view('website.sections.member-cards', [
                'members' => $members->items(),
            ])->render();

            return response()->json([
                'html' => $html,
                'next_page_url' => $members->nextPageUrl(),
            ]);
        }

        return view('website.member-directory', compact('members'));
    }
    public function viewProfile($company_name, $encrypted_id)
    {
        try {
            // Decrypt the ID
            $id = decrypt($encrypted_id);
            
            $member = User::where('role', User::MEMBER)
                ->where('status', 'approved')
                ->where('is_active', true)
                ->where('id', $id)
                ->with(['membershipTier', 'region', 'country', 'city'])
                ->firstOrFail();
            $ports = Port::orderBy('name', 'asc')->get();
            return view('website.member-directory-view-profile', compact('member', 'ports'));
        } catch (\Exception $e) {
            abort(404, 'Member not found');
        }
    }

    /**
     * Process early renewal for the specified member.
     */
    public function earlyRenewal(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        // Validate that member can have early renewal
        if ($member->status !== User::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Only approved members can renew early.');
        }

        if (!$member->membership_expires_at || Carbon::parse($member->membership_expires_at)->isPast()) {
            return redirect()->back()->with('error', 'Cannot process early renewal for expired membership.');
        }

        // Validate renewal details
        $request->validate([
            'early_renewal_reason' => 'required|string|max:500',
        ]);

        // Create early renewal plan
        $renewalService = app(\App\Services\MembershipRenewalService::class);
        
        try {
            $renewal = $renewalService->createRenewalPlan(
                $member,
                $request->early_renewal_reason
            );

            return redirect()->route('members.edit', $member)
                ->with('success', 'Early renewal plan created successfully. Membership will be extended from current expiry date.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create early renewal plan: ' . $e->getMessage());
        }
    }

    /**
     * Allocate signup reward points to a member
     */
    public function allocatePoints(Request $request, User $member)
    {
        // Ensure only Super Admin can access this
        if (Auth::user()->role !== User::SUPER_ADMIN) {
            abort(403, 'Unauthorized');
        }

        // Validate the request
        $request->validate([
            'points' => 'required|integer|min:1|max:1000',
            'reason' => 'required|string|max:500',
        ]);

        // Ensure member is approved
        if ($member->status !== User::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Points can only be allocated to approved members.');
        }

        try {
            // Create reward points entry
            \DB::table('reward_points')->insert([
                'user_id' => $member->id,
                'activity_type' => 'signup_reward',
                'points' => $request->points,
                'description' => $request->reason,
                'created_at' => utcNow(),
                'updated_at' => utcNow(),
            ]);

            return redirect()->back()->with('success', 
                "Successfully allocated {$request->points} signup reward points to {$member->name}.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Failed to allocate points. Please try again.');
        }
    }
    
} 