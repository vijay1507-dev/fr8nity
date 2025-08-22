<?php

namespace App\Http\Controllers;

use App\Models\MembershipBenefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipBenefitController extends Controller
{
    /**
     * Display a listing of membership benefits
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MembershipBenefit::with('tiers')->orderBy('sort_order');
            
            // Handle search
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function($q) use ($searchValue) {
                    $q->where('title', 'like', "%{$searchValue}%")
                      ->orWhere('description', 'like', "%{$searchValue}%");
                });
            }
            $total = $query->count();
           
            $benefits = $query->get();
            
            $data = $benefits->map(function($benefit) {
                // Build tier badges
                $tierBadges = '';
                if ($benefit->tiers->count() > 0) {
                    $tierNames = $benefit->tiers->take(3)->pluck('name')->toArray();
                    foreach ($tierNames as $tierName) {
                        $tierBadges .= '<span class="badge bg-light text-dark me-1">' . $tierName . '</span>';
                    }
                    
                    if ($benefit->tiers->count() > 3) {
                        $tierBadges .= '<span class="badge bg-secondary">+' . ($benefit->tiers->count() - 3) . ' more</span>';
                    }
                } else {
                    $tierBadges = '<span class="text-muted">Not assigned</span>';
                }
                
                // Build status badge
                $statusClass = $benefit->is_active ? 'success' : 'danger';
                $statusText = $benefit->is_active ? 'Active' : 'Inactive';
                $statusBadge = '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
                
                // Build action buttons
                $editUrl = route('membership-benefits.edit', $benefit);
                $deleteDisabled = $benefit->tiers->count() > 0 ? ' disabled' : '';
                
                $actionButtons = '<div class="d-inline-flex align-items-center gap-2 flex-nowrap">' .
                    '<a href="' . $editUrl . '" class="btn btn-sm btn-outline-success">Edit</a>' .
                    '<form action="' . route('membership-benefits.destroy', $benefit) . '" method="POST" class="d-inline m-0 p-0">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this membership benefit?\')"' . $deleteDisabled . '>Delete</button>' .
                    '</form>' .
                '</div>';
                
                return [
                    'sort_order' => $benefit->sort_order,
                    'title' => '<div><h6 class="mb-1">' . $benefit->title . '</h6><small class="text-muted">ID: #' . $benefit->id . '</small></div>',
                    'tiers' => $tierBadges,
                    'status' => $statusBadge,
                    'action' => $actionButtons
                ];
            });
            
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data
            ]);
        }
        
        return view('dashboard.membership-benefits.index');
    }

    /**
     * Show the form for creating a new membership benefit
     */
    public function create()
    {
        return view('dashboard.membership-benefits.create');
    }

    /**
     * Store a newly created membership benefit
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:membership_benefits',
            'description' => 'nullable|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $benefit = MembershipBenefit::create([
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('membership-benefits.index')->with('success', 'Membership benefit created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating membership benefit: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified membership benefit
     */
    public function edit(MembershipBenefit $membershipBenefit)
    {
        return view('dashboard.membership-benefits.edit', compact('membershipBenefit'));
    }

    /**
     * Update the specified membership benefit
     */
    public function update(Request $request, MembershipBenefit $membershipBenefit)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:membership_benefits,title,' . $membershipBenefit->id,
            'description' => 'nullable|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $membershipBenefit->update([
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('membership-benefits.index')->with('success', 'Membership benefit updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating membership benefit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified membership benefit
     */
    public function destroy(MembershipBenefit $membershipBenefit)
    {
        try {
            // Check if benefit is used by any tiers
            if ($membershipBenefit->tiers()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete benefit as it is assigned to membership tiers.');
            }

            $membershipBenefit->delete();

            return redirect()->route('membership-benefits.index')->with('success', 'Membership benefit deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting membership benefit: ' . $e->getMessage());
        }
    }

    /**
     * Toggle benefit status
     */
    public function toggleStatus(MembershipBenefit $membershipBenefit)
    {
        $membershipBenefit->update([
            'is_active' => !$membershipBenefit->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $membershipBenefit->is_active
        ]);
    }
}
