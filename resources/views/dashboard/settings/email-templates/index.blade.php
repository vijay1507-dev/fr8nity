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

                    @if($templates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Variables</th>
                                        <th>Last Updated</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                    <tr>
                                        <td>
                                            <strong>{{ $template->name }}</strong>
                                            @if($template->comment)
                                                <br><small class="text-muted">{{ Str::limit($template->comment, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($template->subject, 40) }}</td>
                                        <td>
                                            @if($template->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($template->variables && count($template->variables) > 0)
                                                <span class="badge bg-info">{{ count($template->variables) }} vars</span>
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td>{{ $template->updated_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-inline-flex align-items-center gap-2 flex-nowrap">
                                                <a href="{{ route('settings.email-templates.show', $template) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('settings.email-templates.edit', $template) }}" 
                                                   class="btn btn-sm btn-outline-success" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('settings.email-templates.toggle-status', $template) }}" 
                                                      class="d-inline toggle-status-form" 
                                                      data-action="{{ $template->is_active ? 'deactivate' : 'activate' }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-warning" 
                                                            title="{{ $template->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="fas fa-{{ $template->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" 
                                                      action="{{ route('settings.email-templates.destroy', $template) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this template? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($templates->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $templates->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Email Templates Found</h5>
                            <p class="text-muted mb-4">Get started by creating your first email template.</p>
                            <a href="{{ route('settings.email-templates.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create Email Template
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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

    // Handle toggle status form submissions
    const toggleForms = document.querySelectorAll('.toggle-status-form');
    toggleForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const action = this.getAttribute('data-action');
            const message = `Are you sure you want to ${action} this template?`;
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection