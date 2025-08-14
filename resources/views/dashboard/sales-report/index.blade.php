@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sales Report - Giver & Receiver Report</h4>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                                         <div class="alert alert-info mb-3">
                         <i class="bi bi-info-circle me-2"></i>
                         <strong>Note:</strong> This report will only include successful transactions. Pending or failed transactions are excluded.
                     </div>
                    
                    <form id="exportForm" action="{{ route('sales-report.export') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Member Selection -->
                                <div class="mb-3">
                                    <label for="member_id" class="form-label">Select Member <span class="text-danger">*</span></label>
                                    <select class="form-select" id="member_id" name="member_id" required>
                                        <option value="">Choose a member...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a member.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <!-- Date Range Selection -->
                                <div class="mb-3">
                                    <label class="form-label">Date Range (Optional)</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="date_from" class="form-label">From Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="date_from" name="date_from" placeholder="Select date" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date_to" class="form-label">To Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="date_to" name="date_to" placeholder="Select date" readonly>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Leave empty to export all records for the selected member
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-sm btn-success btn-lg" id="downloadBtn">
                                    <i class="bi bi-download me-2"></i>
                                    Download CSV Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/sales-report.js') }}?v={{ time() }}"></script>
<script>
// Wait for the script to load and then initialize
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure the script is fully loaded
    setTimeout(function() {
        if (typeof SalesReport !== 'undefined') {
            console.log('Initializing SalesReport module...');
            SalesReport.init({
                export: '{{ route("sales-report.export") }}',
                members: '{{ route("sales-report.members") }}'
            });
        } else {
            console.error('SalesReport module not found. Script may not have loaded properly.');
        }
    }, 100);
});
</script>
@endsection
