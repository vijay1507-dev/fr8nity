@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Export Master Report based on Membership Type</h4>
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
                        <strong>Note:</strong> This report will generate comprehensive member data grouped by membership type for the selected date range.
                    </div>
                    
                    <form id="exportForm" action="{{ route('reports.membership-type.export') }}" method="POST">
                        @csrf
                        
                        <div class="row">
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
                                        Leave empty to export all member records grouped by membership type
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    flatpickr("#date_from", {
        dateFormat: "Y-m-d",
        maxDate: "today"
    });
    
    flatpickr("#date_to", {
        dateFormat: "Y-m-d",
        maxDate: "today"
    });

    // Form validation
    document.getElementById('exportForm').addEventListener('submit', function(e) {
        const fromDate = document.getElementById('date_from').value;
        const toDate = document.getElementById('date_to').value;
        
        if (fromDate && toDate && fromDate > toDate) {
            e.preventDefault();
            alert('From date cannot be greater than To date');
            return false;
        }
        
        // Show loading state
        const downloadBtn = document.getElementById('downloadBtn');
        downloadBtn.disabled = true;
        downloadBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating Report...';
        
        // Re-enable button after 3 seconds (in case of error)
        setTimeout(function() {
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = '<i class="bi bi-download me-2"></i>Download CSV Report';
        }, 3000);
    });
});
</script>
@endsection
