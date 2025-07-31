<?php

namespace App\Http\Controllers;

use App\Models\TradeMember;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TradeMemberController extends Controller
{
    /**
     * Display a listing of trade members.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TradeMember::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $viewBtn = '<a href="' . route('trade-members.show', $row) . '" class="btn btn-sm btn-outline-primary">View</a>';
                    $editBtn = '<a href="' . route('trade-members.edit', $row) . '" class="btn btn-sm ms-2 btn-outline-success">Edit</a>';
                    $deleteBtn = '<form action="' . route('trade-members.destroy', $row) . '" method="POST" style="display:inline-block; margin-left:8px;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                                  </form>';
                
                    return $viewBtn . $editBtn . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.members.tradeMember.index');
    }

    /**
     * Store a newly created trade member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'product_industry_category' => 'required|string|max:255',
            'shipping_frequency' => 'required|array|min:1',
            'mode_of_shipment' => 'required|array|min:1',
            'origin_country' => 'required|integer',
            'destination_country' => 'required|integer',
            'estimated_shipment_volume' => 'required|string|max:255',
            'looking_for' => 'required|array|min:1',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_phone' => 'required|string|max:20',
            'additional_details' => 'nullable|string',
            'consent' => 'required|accepted'
        ]);

        $tradeMember = TradeMember::create([
            'company_name' => $validated['company_name'],
            'product_industry_category' => $validated['product_industry_category'],
            'shipping_frequency' => $validated['shipping_frequency'],
            'mode_of_shipment' => $validated['mode_of_shipment'],
            'origin_country' => $validated['origin_country'],
            'destination_country' => $validated['destination_country'],
            'estimated_shipment_volume' => $validated['estimated_shipment_volume'],
            'looking_for' => $validated['looking_for'],
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'email' => $validated['email'],
            'whatsapp_phone' => $validated['whatsapp_phone'],
            'additional_details' => $validated['additional_details'],
            'consent' => true
        ]);

        return redirect()->back()->with('success', 'Your request has been submitted successfully.');
    }

    /**
     * Show the form for editing the specified trade member.
     */
    public function edit(TradeMember $tradeMember)
    {
        return view('dashboard.members.tradeMember.edit', compact('tradeMember'));
    }

    /**
     * Display the specified trade member.
     */
    public function show(TradeMember $tradeMember)
    {
        return view('dashboard.members.tradeMember.show', compact('tradeMember'));
    }

    /**
     * Update the specified trade member in storage.
     */
    public function update(Request $request, TradeMember $tradeMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_phone' => 'required',
            'company_name' => 'required|string|max:255',
            'product_industry_category' => 'required|string|max:255',
            'shipping_frequency' => 'required|array|min:1',
            'mode_of_shipment' => 'required|array|min:1',
            'origin_country' => 'required|integer',
            'destination_country' => 'required|integer',
            'estimated_shipment_volume' => 'required|string|max:255',
            'looking_for' => 'required|array|min:1',
            'additional_details' => 'nullable|string'
        ]);

        $tradeMember->update($validated);

        return redirect()
            ->route('trade-members.show', $tradeMember)
            ->with('success', 'Trade member updated successfully.');
    }

    /**
     * Remove the specified trade member from storage.
     */
    public function destroy(TradeMember $tradeMember)
    {
        $tradeMember->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('trade-members.index')
            ->with('success', 'Trade member deleted successfully.');
    }
} 