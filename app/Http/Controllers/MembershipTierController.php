<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\MembershipBenefit;
use App\Models\MembershipTierReward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MembershipTierController extends Controller
{
    /**
     * Display a listing of membership tiers
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MembershipTier::with(['benefits', 'rewards'])->orderBy('order');
            
            // Handle search
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('description', 'like', "%{$searchValue}%")
                      ->orWhere('credit_protection', 'like', "%{$searchValue}%");
                });
            }
            
            $total = $query->count();
            $tiers = $query->get();
            
            $data = $tiers->map(function($tier) {
                // Build status badges
                $statusClass = $tier->is_active ? 'success' : 'danger';
                $statusText = $tier->is_active ? 'Active' : 'Inactive';
                $visibilityClass = $tier->is_visible ? 'info' : 'secondary';
                $visibilityText = $tier->is_visible ? 'Visible' : 'Hidden';
                
                $statusBadges = '<div class="d-flex flex-column gap-1">' .
                    '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>' .
                    '<span class="badge bg-' . $visibilityClass . '">' . $visibilityText . '</span>' .
                '</div>';
                
                // Build action buttons
                $editUrl = route('membership-tiers.edit', $tier);
                $showUrl = route('membership-tiers.show', $tier);
                
                $actionButtons = '<div class="d-inline-flex align-items-center gap-2 flex-nowrap">' .
                    '<a href="' . $showUrl . '" class="btn btn-sm btn-outline-primary">View</a>' .
                    '<a href="' . $editUrl . '" class="btn btn-sm btn-outline-success">Edit</a>' .
                    '<form action="' . route('membership-tiers.destroy', $tier) . '" method="POST" class="d-inline m-0 p-0">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this membership tier?\')">Delete</button>' .
                    '</form>' .
                '</div>';
                
                return [
                    'order' => $tier->order,
                    'name' => '<div><h6 class="mb-1">' . $tier->name . '</h6><small class="text-muted">' . Str::limit($tier->description, 50) . '</small></div>',
                    'annual_fee' => $tier->formatted_annual_fee,
                    'credit_protection' => Str::limit($tier->credit_protection, 30),
                    'status' => $statusBadges,
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
        
        return view('dashboard.membership-tiers.index');
    }

    /**
     * Show the form for creating a new membership tier
     */
    public function create()
    {
        $benefits = MembershipBenefit::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $defaultActivityTypes = MembershipTierReward::select('activity_type')
            ->selectRaw('MAX(CASE WHEN label IS NOT NULL AND label != "" THEN label ELSE NULL END) as label')
            ->groupBy('activity_type')
            ->orderBy('activity_type')
            ->get();

        return view('dashboard.membership-tiers.create', compact('benefits', 'defaultActivityTypes'));
    }

    /**
     * Store a newly created membership tier
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:membership_tiers',
            'description' => 'required|string',
            'credit_protection' => 'required|string|max:255',
            'annual_fee' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_visible' => 'boolean',
            'benefits' => 'array',
            'benefits.*' => 'exists:membership_benefits,id',
           
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            if($request->annual_fee){
                $currency = 'USD ' . $request->annual_fee . '/year';
            }
            $tier = MembershipTier::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'credit_protection' => $request->credit_protection,
                'annual_fee' => $request->annual_fee,
                'annual_fee_currency' => $currency ?? null,
                'order' => $request->order,
                'is_active' => $request->boolean('is_active', true),
                'is_visible' => $request->boolean('is_visible', true),
            ]);
            // Attach benefits
            if ($request->has('benefits')) {
                $tier->benefits()->attach($request->benefits);
            }

            // Create rewards
            if ($request->has('rewards')) {
                foreach ($request->rewards as $reward) {
                    if (!empty($reward['activity_type']) && !empty($reward['points'])) {
                        $tier->rewards()->create([
                            'activity_type' => $reward['activity_type'],
                            'label' => $reward['label'] ?? null,
                            'points' => $reward['points'],
                            'multiplier' => $reward['multiplier'] ?? 1.00,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('membership-tiers.index')->with('success', 'Membership tier created successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating membership tier: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified membership tier
     */
    public function show(MembershipTier $membershipTier)
    {
        $membershipTier->load(['benefits', 'rewards']);
        return view('dashboard.membership-tiers.show', compact('membershipTier'));
    }

    /**
     * Show the form for editing the specified membership tier
     */
    public function edit(MembershipTier $membershipTier)
    {
        $membershipTier->load(['benefits', 'rewards']);
        $benefits = MembershipBenefit::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('dashboard.membership-tiers.edit', compact('membershipTier', 'benefits'));
    }

    /**
     * Update the specified membership tier
     */
    public function update(Request $request, MembershipTier $membershipTier)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:membership_tiers,name,' . $membershipTier->id,
            'description' => 'required|string',
            'credit_protection' => 'required|string|max:255',
            'annual_fee' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_visible' => 'boolean',
            'benefits' => 'array',
            'benefits.*' => 'exists:membership_benefits,id',
           
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            if($request->annual_fee){
                $currency = 'USD ' . $request->annual_fee . '/year';
            }
            $membershipTier->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'credit_protection' => $request->credit_protection,
                'annual_fee' => $request->annual_fee,
                'annual_fee_currency' => $currency ?? null,
                'order' => $request->order,
                'is_active' => $request->boolean('is_active', true),
                'is_visible' => $request->boolean('is_visible', true),
            ]);

            // Sync benefits
            $membershipTier->benefits()->sync($request->benefits ?? []);
            // Handle rewards
            if ($request->has('rewards')) {
                $existingRewardIds = [];
                
                foreach ($request->rewards as $reward) {
                    if (!empty($reward['activity_type']) && !empty($reward['points'])) {
                        if (isset($reward['id'])) {
                            // Update existing reward
                            $membershipTier->rewards()->where('id', $reward['id'])->update([
                                'activity_type' => $reward['activity_type'],
                                'label' => $reward['label'] ?? null,
                                'points' => $reward['points'],
                                'multiplier' => $reward['multiplier'] ?? 1.00,
                            ]);
                            $existingRewardIds[] = $reward['id'];
                        } else {
                            // Create new reward
                            $newReward = $membershipTier->rewards()->create([
                                'activity_type' => $reward['activity_type'],
                                'label' => $reward['label'] ?? null,
                                'points' => $reward['points'],
                                'multiplier' => $reward['multiplier'] ?? 1.00,
                            ]);
                            $existingRewardIds[] = $newReward->id; // ✅ prevent deletion
                        }
                    }
                }
                
                // Delete rewards that are no longer in the list
                $membershipTier->rewards()->whereNotIn('id', $existingRewardIds)->delete();
            } else {
                // If no rewards provided, delete all existing ones
                $membershipTier->rewards()->delete();
            }
            DB::commit();
            return redirect()->route('membership-tiers.index')->with('success', 'Membership tier updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating membership tier: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified membership tier
     */
    public function destroy(MembershipTier $membershipTier)
    {
        try {
            DB::beginTransaction();
            
            // Delete related records
            $membershipTier->benefits()->detach();
            $membershipTier->rewards()->delete();
            $membershipTier->delete();
            
            DB::commit();
            return redirect()->route('membership-tiers.index')->with('success', 'Membership tier deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting membership tier: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle tier status
     */
    public function toggleStatus(MembershipTier $membershipTier)
    {
        $membershipTier->update([
            'is_active' => !$membershipTier->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $membershipTier->is_active
        ]);
    }

    /**
     * Toggle tier visibility
     */
    public function toggleVisibility(MembershipTier $membershipTier)
    {
        $membershipTier->update([
            'is_visible' => !$membershipTier->is_visible
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visibility updated successfully!',
            'is_visible' => $membershipTier->is_visible
        ]);
    }

    /**
     * Get benefits for AJAX requests
     */
    public function getBenefits()
    {
        $benefits = MembershipBenefit::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'title', 'description']);

        return response()->json($benefits);
    }
}
