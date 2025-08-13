<?php

namespace App\Http\Controllers;

use App\Services\SalesReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    protected $salesReportService;

    public function __construct(SalesReportService $salesReportService)
    {
        $this->salesReportService = $salesReportService;
        
        // Ensure only super admin can access
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== \App\Models\User::SUPER_ADMIN) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Display the sales report index page
     */
    public function index()
    {
        return view('dashboard.sales-report.index');
    }

    /**
     * Get all members for dropdown
     */
    public function getMembers()
    {
        $members = $this->salesReportService->getMembers();
        return response()->json($members);
    }

    /**
     * Export sales report as CSV
     */
    public function export(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $memberId = $request->member_id;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        // Get member details
        $member = $this->salesReportService->getMember($memberId);

        // Get successful quotations
        $quotations = $this->salesReportService->getSuccessfulQuotations($memberId, $dateFrom, $dateTo);

        // Check if any records found
        if (!$this->salesReportService->hasQuotations($quotations)) {
            return response()->json([
                'success' => false,
                'message' => 'No records found for the selected member and date range. Please try different criteria.',
                'member' => $member->name . ' - ' . $member->company_name,
                'date_range' => [
                    'from' => $dateFrom,
                    'to' => $dateTo
                ]
            ], 404);
        }

        // Generate CSV content
        $csvData = $this->salesReportService->generateCsvData($quotations, $member);

        // Generate filename
        $filename = $this->salesReportService->generateFilename($member);

        // Return CSV response
        return response($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }


}
