<?php

namespace App\Http\Controllers;

use App\Models\MemberQuotation;
use App\Notifications\QuotationNotification;
use App\Services\MemberQuotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MemberQuotationController extends Controller
{
    public function __construct(private readonly MemberQuotationService $memberQuotationService)
    {
    }
    public function index(Request $request)
    {
        $quotations = MemberQuotation::with(['portOfLoading', 'portOfDischarge'])
        ->where('member_id', Auth::id());
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
                    $url = route('member.quotations.show', $row);
                    return '<a href="'.$url.'" class="btn btn-sm btn-info">View</a>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.index');
    }

    public function show(MemberQuotation $quotation)
    {
        // Check if the quotation belongs to the current user
        if ($quotation->member_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.quotations.show', compact('quotation'));
    }

    // Admin: list all quotations
    public function adminIndex(Request $request)
    {
        $this->authorizeAdmin();

        $quotations = MemberQuotation::with(['member', 'portOfLoading', 'portOfDischarge']);

        if ($request->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('member', function ($quotation) {
                    return $quotation->member ? $quotation->member->company_name : '-';
                })
                ->addColumn('port_of_loading', function ($quotation) {
                    return $quotation->portOfLoading ? $quotation->portOfLoading->name : null;
                })
                ->addColumn('port_of_discharge', function ($quotation) {
                    return $quotation->portOfDischarge ? $quotation->portOfDischarge->name : null;
                })
                ->addColumn('action', function ($row) {
                    $url = route('admin.quotations.show', $row);
                    return '<a href="'.$url.'" class="btn btn-sm btn-info">View</a>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.admin-index');
    }

    // Admin: show single quotation with both sender and receiver details
    public function adminShow(MemberQuotation $quotation)
    {
        $this->authorizeAdmin();
        $quotation->load(['member', 'portOfLoading', 'portOfDischarge']);
        return view('dashboard.quotations.admin-show', compact('quotation'));
    }

    private function authorizeAdmin(): void
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, [\App\Models\User::SUPER_ADMIN, \App\Models\User::ADMIN])) {
            abort(403, 'Unauthorized Access.');
        }
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

        $quotation = $this->memberQuotationService->createAndNotify($validated, $request->file('document'));

        return redirect()->back()->with('success', 'Quotation request submitted successfully');
    }
}