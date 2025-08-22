@extends('layouts.dashboard')

@section('title', 'Member Sales Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Member Sales Report</h4>
                    <p class="card-subtitle text-muted">Generate your sales report based on date range</p>
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
                    
                    <form id="memberExportForm" action="{{ route('member.sales-report.export') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Date Range Selection -->
                                <div class="mb-3">
                                    <label class="form-label">Date Range <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="date_from" class="form-label">From Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="date_from" name="date_from" placeholder="Select start date" required readonly>
                                            <div class="invalid-feedback">
                                                Please select a start date.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date_to" class="form-label">To Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="date_to" name="date_to" placeholder="Select end date" required readonly>
                                            <div class="invalid-feedback">
                                                Please select an end date.
                                            </div>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Select the date range for your sales report. Both dates are required.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Report Summary Preview -->
                        <div class="row mb-3" id="reportPreview" style="display: none;">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Report Summary</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Date Range:</strong> <span id="previewDateRange"></span></p>
                                                <p class="mb-1"><strong>Total Transactions:</strong> <span id="previewTotalTransactions"></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Total Value:</strong> <span id="previewTotalValue"></span></p>
                                                <p class="mb-1"><strong>Member:</strong> <span id="previewMemberName"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg" id="downloadBtn">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="{{ asset('js/member-sales-report.js') }}?v={{ time() }}"></script>
@endsection
