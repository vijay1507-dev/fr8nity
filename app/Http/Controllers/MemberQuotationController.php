<?php

namespace App\Http\Controllers;

use App\Models\MemberQuotation;
use App\Notifications\QuotationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class MemberQuotationController extends Controller
{
    public function index(Request $request)
    {
        $quotations = MemberQuotation::with(['portOfLoading', 'portOfDischarge'])
        ->where('member_id', auth()->id());
        if ($request->ajax()) {
          
            return DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('port_of_loading', function ($quotation) {
                    return $quotation->portOfLoading ? $quotation->portOfLoading->name : null;
                })
                ->addColumn('port_of_discharge', function ($quotation) {
                    return $quotation->portOfDischarge ? $quotation->portOfDischarge->name : null;
                })
                ->addColumn('action', function ($row) {
                    $url = route('member.quotations.show', $row->id);
                    return '<a href="'.$url.'" class="btn btn-sm btn-info">View</a>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.index');
    }

    public function show(MemberQuotation $quotation)
    {
        // Check if the quotation belongs to the current user
        if ($quotation->member_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.quotations.show', compact('quotation'));
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alternate_email' => 'nullable|email|max:255',
            'document' => 'nullable|file|max:10240', // 10MB max
            'port_of_loading_id' => 'nullable|exists:cities,id',
            'port_of_discharge_id' => 'nullable|exists:cities,id',
            'specifications' => 'nullable|array',
            'specifications.*' => 'string|in:Air,FCL,LCL,Land,Multimodal,Project Cargo',
            'message' => 'required|string',
        ], [
            'name.required' => 'Please enter your name.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Message is required.',
        ]);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('quotation-documents', 'public');
            $validated['uploaded_document'] = $path;
        }

        $quotation = MemberQuotation::create($validated);
        
        // Send notifications
        // Send to super admin
        Notification::route('mail', config('mail.super_admin_email'))
            ->notify(new QuotationNotification($quotation, true));

        // Send to receiver (member)
        $quotation->member->notify(new QuotationNotification($quotation));

        // Send to sender
        Notification::route('mail', $quotation->email)
            ->notify(new QuotationNotification($quotation, false, true));
        
        return redirect()->back()->with('success', 'Quotation request submitted successfully');
    }
}