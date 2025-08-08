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
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function __construct(
        private readonly MemberApprovalService $memberApprovalService,
        private readonly MembershipNumberService $membershipNumberService,
    ) {
    }
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
                ->addColumn('membership_start_at', function($row) {
                    return $row->membership_start_at ? $row->membership_start_at->format('d-m-Y') : 'N/A';
                })
                ->addColumn('membership_expires_at', function($row) {
                    return $row->membership_expires_at ? $row->membership_expires_at->format('d-m-Y') : 'N/A';
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
        $totalPoints = $member->rewardPoints()->sum('points');
        return view('dashboard.members.show', compact('member', 'membershipTiers','membershipName','totalPoints'));
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

        $this->memberApprovalService->updateStatus($member, $request->status);

        return back()->with('success', 'Member status updated successfully.');
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
                'certificate_document' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
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
                $updateData['certificate_uploaded_at'] = now();
            }
            $membershipNumber = $this->membershipNumberService->generateForTierId((int) $request->membership_tier);
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
                'certificate_document' => $certificatePath,
                'certificate_uploaded_at' => now(),
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
    public function directory(Request $request)
    {
        $query = User::where('role', User::MEMBER)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->with(['membershipTier', 'region', 'country', 'city']);

        // Filter by company name
        if ($request->filled('company_name')) {
            $query->where(function($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->company_name . '%')
                  ->orWhere('name', 'like', '%' . $request->company_name . '%');
            });
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->whereHas('country', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->country . '%');
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->whereHas('city', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->city . '%');
            });
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $specialization = $request->specialization;
            $query->where(function($q) use ($specialization) {
                $q->where('specializations', 'like', '%' . $specialization . '%')
                  ->orWhere('specializations', 'like', '%"' . $specialization . '"%');
            });
        }

        $members = $query->get();

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
            $ports = Port::all();
            return view('website.member-directory-view-profile', compact('member', 'ports'));
        } catch (\Exception $e) {
            abort(404, 'Member not found');
        }
    }
    
} 