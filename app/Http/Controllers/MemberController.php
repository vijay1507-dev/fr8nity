<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTier;
use App\Models\TradeMember;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->where('role', User::MEMBER)->with('membershipTier');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('current_tier', function($row) {
                    return $row->membershipTier->name;
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->addColumn('action', function($row) {
                    $viewBtn = '<a href="' . route('members.show', $row) . '" class="btn btn-sm btn-outline-primary">View</a>';
                    $editBtn = '<a href="' . route('members.edit', $row) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    $deleteBtn = '<form action="' . route('members.destroy', $row) . '" method="POST" style="display:inline-block;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this member?\')">Delete</button>
                                  </form>';
                    return $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.members.index');
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
        return view('dashboard.members.show', compact('member', 'membershipTiers','membershipName'));
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
            'company_name' => ['required', 'string', 'max:255'],
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
            'status' => ['required', 'in:pending,approved'],
        ]);

        // If status is being changed to approved
        if ($request->status === 'approved' && $member->status !== 'approved') {
            // Create and send notification
            $notification = new \App\Notifications\ProfileApprovalNotification();
            
            // Update member with generated password and set membership expiration
            $member->update([
                'status' => $request->status,
                'password' => Hash::make($notification->getPassword()),
                'membership_expires_at' => now()->addYear()
            ]);

            // Send notification with login credentials
            $member->notify($notification);
        } else {
            $member->update([
                'status' => $request->status,
            ]);
        }

        return back()->with('success', 'Member status updated successfully.');
    }

    /**
     * Update the specified member's membership tier.
     */
    public function updateMembershipTier(Request $request, User $member)
    {
        if ($member->role !== User::MEMBER) {
            abort(404);
        }

        $request->validate([
            'membership_tier' => ['required', 'exists:membership_tiers,id'],
        ]);

        $member->update([
            'membership_tier' => $request->membership_tier,
            'membership_expires_at' => now()->addYear(),
        ]);

        if ($request->ajax()) {
            $membershipTier = MembershipTier::with('benefits')->find($request->membership_tier);
            return response()->json([
                'success' => true, 
                'message' => 'Membership tier updated successfully',
                'benefits' => $membershipTier->benefits
            ]);
        }

        return back()->with('success', 'Membership tier updated successfully');
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
        return view('dashboard.members.edit', compact('member', 'membershipTiers'));
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
                'company_logo' => ['nullable', 'image', 'max:2048'],
                'company_description' => ['nullable', 'string', 'max:2000'],
                'profile_photo' => ['nullable', 'image', 'max:2048'],
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
            // Admin validation rules - all fields required
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $member->id],
                'designation' => ['required', 'string', 'max:255'],
                'whatsapp_phone' => ['required'],
                'company_name' => ['required', 'string', 'max:255'],
                'company_logo' => ['nullable', 'image', 'max:2048'],
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
                'profile_photo' => ['nullable', 'image', 'max:2048'],
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
                'membership_tier' => $request->membership_tier,
            ];

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
     * Display the member directory.
     */
    public function directory()
    {
        $members = User::where('role', User::MEMBER)
            ->where('status', 'approved')
            ->with(['membershipTier', 'region', 'country', 'city'])
            ->get();

        return view('website.member-directory', compact('members'));
    }
    public function viewProfile()
    {
        $members = User::where('role', User::MEMBER)
            ->where('status', 'approved')
            ->with(['membershipTier', 'region', 'country', 'city'])
            ->get();

        return view('website.member-directory-view-profile', compact('members'));
    }
    
} 