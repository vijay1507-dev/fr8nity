@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Email Templates</h5>
                    <a href="{{ route('settings.email-templates.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Template
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Variables</th>
                                    <th>Last Updated</th>
                                    <th width="250">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// Initialize DataTable
$(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        autoWidth: false,
        ajax: {
            url: "{{ route('settings.email-templates.index') }}",
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name_with_comment', name: 'name'},
            {data: 'subject_truncated', name: 'subject'},
            {data: 'status_badge', name: 'is_active'},
            {data: 'variables_count', name: 'variables', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ],
        order: [[5, 'desc']], // Order by updated_at by default
        language: {
            emptyTable: `
                <div class="text-center py-5">
                    <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Email Templates Found</h5>
                    <p class="text-muted mb-4">Get started by creating your first email template.</p>
                    <a href="{{ route('settings.email-templates.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create Email Template
                    </a>
                </div>
            `
        }
    });
    
    table.columns.adjust();
});

// Auto-hide success alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endsection