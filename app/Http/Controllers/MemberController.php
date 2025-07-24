<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

        return view('dashboard.members.show', compact('member'));
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

        return back()->with('success', 'Membership tier updated successfully.');
    }
} 