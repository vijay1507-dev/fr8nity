<?php

namespace App\Http\Controllers;

use App\Models\MemberQuotation;
use App\Models\User;
use App\Models\Port;
use App\Notifications\QuotationNotification;
use App\Notifications\QuotationStatusNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\MemberQuotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MemberQuotationController extends Controller
{
    public function __construct(private readonly MemberQuotationService $memberQuotationService)
    {
    }
    public function givenQuotations(Request $request)
    {
        $quotations = MemberQuotation::with(['portOfLoading', 'portOfDischarge', 'receiver'])
            ->where('given_by_id', Auth::id())
            ->latest();

        if ($request->ajax()) {
            return DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('reference_no', function ($quotation) {
                    return $quotation->quotation_reference_no ?? '-';
                })
                ->addColumn('receiver', function ($quotation) {
                    return $quotation->receiver ? $quotation->receiver->company_name : '-';
                })
                ->addColumn('port_of_loading', function ($quotation) {
                    return $quotation->portOfLoading ? $quotation->portOfLoading->name : '-';
                })
                ->addColumn('port_of_discharge', function ($quotation) {
                    return $quotation->portOfDischarge ? $quotation->portOfDischarge->name : '-';
                })
                ->addColumn('status', function ($quotation) {
                    return $quotation->getStatusLabel();
                })
                ->addColumn('created_at', function ($quotation) {
                    return $quotation->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $url = route('member.quotations.show', $row);
                    return '<div class="d-inline-flex align-items-center flex-nowrap"><a href="'.$url.'" class="btn btn-sm btn-info">View</a></div>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.given');
    }

    public function receivedQuotations(Request $request)
    {
        $quotations = MemberQuotation::with(['portOfLoading', 'portOfDischarge', 'givenBy'])
            ->where('receiver_id', Auth::id())
            ->latest();

        if ($request->ajax()) {
            return DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('reference_no', function ($quotation) {
                    return $quotation->quotation_reference_no ?? '-';
                })
                ->addColumn('given_by', function ($quotation) {
                    return $quotation->givenBy ? $quotation->givenBy->company_name : '-';
                })
                ->addColumn('port_of_loading', function ($quotation) {
                    return $quotation->portOfLoading ? $quotation->portOfLoading->name : '-';
                })
                ->addColumn('port_of_discharge', function ($quotation) {
                    return $quotation->portOfDischarge ? $quotation->portOfDischarge->name : '-';
                })
                ->addColumn('transaction_value', function ($quotation) {
                    return $quotation->transaction_value
                        ? '$' . number_format($quotation->transaction_value, 2)
                        : '-';
                })
                ->addColumn('status', function ($quotation) {
                    return $quotation->getStatusLabel();
                })
                ->addColumn('created_at', function ($quotation) {
                    return $quotation->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $url = route('member.quotations.show', $row);
                    return '<div class="d-inline-flex align-items-center flex-nowrap"><a href="'.$url.'" class="btn btn-sm btn-info">View</a></div>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.received');
    }

    public function create(Request $request)
    {
        $type = $request->get('type', 'received');        
        // Get ports for the form dropdowns
        $ports = Port::orderBy('name')->get();
        
        // Get members for the form dropdown
        $members = User::where('role', User::MEMBER)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->where('id', '!=', Auth::id())
            ->orderBy('company_name')
            ->get();

        return view('dashboard.quotations.create', compact('ports', 'members', 'type'));
    }

    public function show(MemberQuotation $quotation)
    {
        // Check if the user is either the giver or receiver of the quotation
        if ($quotation->given_by_id !== Auth::id() && $quotation->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.quotations.show', compact('quotation'));
    }

    public function close(Request $request, MemberQuotation $quotation)
    {
        if ($quotation->given_by_id !== Auth::id() && $quotation->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $quotation->update(['status' => MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL]);

        // Notify SA, sender (external email), and receiver
        $admins = User::where('role', User::SUPER_ADMIN)->get();
        Notification::send($admins, new QuotationStatusNotification($quotation, 'admin'));
        Notification::route('mail', $quotation->email)
            ->notify(new QuotationStatusNotification($quotation, 'sender'));
        if ($quotation->receiver) {
            $quotation->receiver->notify(new QuotationStatusNotification($quotation, 'receiver'));
        }
        return back()->with('success', 'Enquiry closed unsuccessfully.');
    }

    public function success(Request $request, MemberQuotation $quotation)
    {
        if ($quotation->given_by_id !== Auth::id() && $quotation->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'transaction_value' => ['required','numeric','min:0'],
        ]);

        $quotation->update([
            'transaction_value' => $validated['transaction_value'],
            'status' => MemberQuotation::STATUS_CLOSED_SUCCESSFUL,
        ]);

        // Notify SA, sender (external email), and receiver
        $admins = User::where('role', User::SUPER_ADMIN)->get();
        Notification::send($admins, new QuotationStatusNotification($quotation, 'admin'));
        Notification::route('mail', $quotation->email)
            ->notify(new QuotationStatusNotification($quotation, 'sender'));
        if ($quotation->receiver) {
            $quotation->receiver->notify(new QuotationStatusNotification($quotation, 'receiver'));
        }

        return back()->with('success', 'Quotation marked successful.');
    }

    // Admin: list all quotations
    public function adminIndex(Request $request)
    {
        $this->authorizeAdmin();

        $quotations = MemberQuotation::with(['receiver', 'portOfLoading', 'portOfDischarge'])
            ->latest();

        if ($request->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::of($quotations)
                ->addIndexColumn()
                ->addColumn('reference_no', function ($quotation) {
                    return $quotation->quotation_reference_no ?? '-';
                })
                ->addColumn('member', function ($quotation) {
                    return $quotation->receiver ? $quotation->receiver->company_name : '-';
                })
                ->addColumn('company_name', function ($quotation) {
                    return $quotation->receiver ? $quotation->receiver->company_name : '-';
                })
                ->addColumn('sender_company_name', function ($quotation) {
                    return $quotation->givenBy ? $quotation->givenBy->company_name : '-';
                })
                ->addColumn('sender_email', function ($quotation) {
                    return $quotation->givenBy ? $quotation->givenBy->email : '-';
                })
                ->addColumn('email', function ($quotation) {
                    return $quotation->receiver ? $quotation->receiver->email : '-';
                })
                ->addColumn('transaction_value', function ($quotation) {
                    return $quotation->transaction_value
                        ? '$' . number_format($quotation->transaction_value, 2)
                        : '-';
                })
                ->addColumn('status', function ($quotation) {
                    return $quotation->getStatusLabel();
                })
                ->addColumn('created_at', function ($quotation) {
                    return $quotation->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $url = route('admin.quotations.show', $row);
                    return '<div class="d-inline-flex align-items-center flex-nowrap"><a href="'.$url.'" class="btn btn-sm btn-info">View</a></div>';
                })
                ->make(true);
        }

        return view('dashboard.quotations.admin-index');
    }

    // Admin: show single quotation with both sender and receiver details
    public function adminShow(MemberQuotation $quotation)
    {
        $this->authorizeAdmin();
        $quotation->load(['receiver', 'portOfLoading', 'portOfDischarge']);
        return view('dashboard.quotations.admin-show', compact('quotation'));
    }

    // Admin: create offline quotation form
    public function adminCreate()
    {
        $this->authorizeAdmin();
        
        // Get all active approved members for both giver and receiver selection
        $members = User::where('role', User::MEMBER)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->orderBy('company_name')
            ->get();
            
        // Get ports for the form dropdowns
        $ports = Port::orderBy('name')->get();
        
        return view('dashboard.quotations.admin-create', compact('members', 'ports'));
    }

    // Admin: store offline quotation
    public function adminStore(Request $request)
    {
        $this->authorizeAdmin();
        
        $rules = [
            'given_by_id'         => 'required|exists:users,id',
            'receiver_id'         => 'required|exists:users,id|different:given_by_id',
            'transaction_value'   => 'required|numeric|min:0',
            'message'             => 'required|string',
            'port_of_loading_id'  => 'nullable|exists:ports,id',
            'port_of_discharge_id'=> 'nullable|exists:ports,id',
            'specifications'      => 'nullable|array',
            'specifications.*'    => 'string|in:Air,FCL,LCL,Land,Multimodal,Project Cargo',
        ];
        
        $validated = $request->validate($rules, [
            'given_by_id.required'              => 'Please select a giver member.',
            'receiver_id.required'              => 'Please select a receiver member.',
            'receiver_id.different'             => 'Giver and receiver cannot be the same member.',
            'transaction_value.required'        => 'Transaction value is required.',
            'transaction_value.numeric'         => 'Transaction value must be a number.',
            'transaction_value.min'             => 'Transaction value must be greater than or equal to 0.',
            'message.required'                  => 'Message is required.',
        ]);
        
        // Get giver member details to populate quotation fields
        $givenBy = User::find($validated['given_by_id']);
        
        // Merge member details into the validated data
        $validated = array_merge($validated, [
            'name'   => $givenBy->name,
            'phone'  => $givenBy->whatsapp_phone ?? $givenBy->company_telephone,
            'email'  => $givenBy->email,
            'status' => MemberQuotation::STATUS_CLOSED_SUCCESSFUL,
            'is_offline_enquiry' => 1
        ]);
        
        $this->memberQuotationService->createAndNotify($validated, null);
        
        return redirect()->route('admin.quotations.index')->with('success', 'Offline quotation added successfully.');
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
        if ($request->is_offline_enquiry == 1) {
            $givenBy = User::find($request->given_by_id);
        
            if ($givenBy) {
                $request->merge([
                    'name'   => $givenBy->name,
                    'phone'  => $givenBy->whatsapp_phone,
                    'email'  => $givenBy->email,
                    'status' => MemberQuotation::STATUS_CLOSED_SUCCESSFUL,
                ]);
            }
        }
        
        // base rules
        $rules = [
            'receiver_id'         => 'required|exists:users,id',
            'given_by_id'         => 'required|exists:users,id',
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'alternate_email'     => 'nullable|email|max:255',
            'document'            => 'nullable|file|max:10240', 
            'port_of_loading_id'  => 'nullable|exists:ports,id',
            'port_of_discharge_id'=> 'nullable|exists:ports,id',
            'specifications'      => 'nullable|array',
            'specifications.*'    => 'string|in:Air,FCL,LCL,Land,Multimodal,Project Cargo',
            'message'             => 'required|string',
        ];
        
        // if offline enquiry, require transaction_value
        if ($request->is_offline_enquiry == 1) {
            $rules['transaction_value'] = 'required|numeric|min:0';
            // status already merged into request, so validation can allow it
            $rules['status'] = 'nullable';
        }
        
        $validated = $request->validate($rules, [
            'name.required'              => 'Please enter your name.',
            'phone.required'             => 'Phone number is required.',
            'email.required'             => 'Email is required.',
            'email.email'                => 'Please enter a valid email address.',
            'message.required'           => 'Message is required.',
            'transaction_value.required' => 'Transaction value is required.',
            'transaction_value.numeric'  => 'Transaction value must be a number.',
            'transaction_value.min'      => 'Transaction value must be greater than or equal to 0.',
        ]);
        
        $this->memberQuotationService->createAndNotify($validated, $request->file('document'));
        
        if($request->is_offline_enquiry == 1){
            // Check if this is a given or received quotation and redirect accordingly
            if ($request->quotation_type === 'given') {
                return redirect()->route('member.quotations.given')->with('success', 'Enquiry Added successfully');
            } else {
                return redirect()->route('member.quotations.received')->with('success', 'Enquiry Added successfully');
            }
        }
        return redirect()->back()->with('success', 'Quotation request submitted successfully');
    }
}