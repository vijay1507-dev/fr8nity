<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
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
            $data = User::query()->where('role', User::MEMBER);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="' . route('members.show', $row) . '" class="btn btn-sm">View</a>';
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
            'status' => 'approved',
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

        $member->update([
            'status' => $request->status,
        ]);

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
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Membership tier updated successfully']);
        }

        return back()->with('success', 'Membership tier updated successfully');
    }
} 