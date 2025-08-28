@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Email Template: {{ $mailTemplate->name }}
                        @if($mailTemplate->is_active)
                            <span class="badge bg-success ms-2">Active</span>
                        @else
                            <span class="badge bg-secondary ms-2">Inactive</span>
                        @endif
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('settings.email-templates.edit', $mailTemplate) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('settings.email-templates.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Templates
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Template Details -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6 class="text-muted text-uppercase">Email Subject</h6>
                                    <div class="p-3 bg-light rounded border">
                                        {{ $mailTemplate->subject }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-muted text-uppercase mb-0">Email Body</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showPreview()">
                                            <i class="fas fa-eye me-1"></i> Preview HTML
                                        </button>
                                    </div>
                                    <div class="p-3 bg-light rounded border mt-2" style="max-height: 400px; overflow-y: auto;">
                                        <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">{{ $mailTemplate->body }}</pre>
                                    </div>
                                </div>

                                @if($mailTemplate->comment)
                                <div class="col-12">
                                    <h6 class="text-muted text-uppercase">Comments/Notes</h6>
                                    <div class="p-3 bg-light rounded border">
                                        {{ $mailTemplate->comment }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Template Info Sidebar -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">Template Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong class="text-muted">Status:</strong><br>
                                        @if($mailTemplate->is_active)
                                            <span class="badge bg-success">Active</span>
                                            <small class="d-block text-muted mt-1">This template can be used for sending emails</small>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                            <small class="d-block text-muted mt-1">This template is currently disabled</small>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <strong class="text-muted">Template Name:</strong><br>
                                        <code>{{ $mailTemplate->name }}</code>
                                    </div>
                                    @if($mailTemplate->variables && count($mailTemplate->variables) > 0)
                                        <div class="mb-3">
                                            <strong class="text-muted">Available Variables:</strong><br>
                                            <div class="mt-2">
                                                @foreach($mailTemplate->variables as $variable)
                                                    <span class="badge bg-info me-1 mb-1">{{ '{' . '{' . $variable . '}' . '}' }}</span>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Use these variables in your email content</small>
                                        </div>
                                    @endif


                                    <div class="mb-3">
                                        <strong class="text-muted">Created:</strong><br>
                                        <small>{{ $mailTemplate->created_at->format('M d, Y \a\t g:i A') }}</small>
                                    </div>

                                    <div class="mb-3">
                                        <strong class="text-muted">Last Updated:</strong><br>
                                        <small>{{ $mailTemplate->updated_at->format('M d, Y \a\t g:i A') }}</small>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="border-top pt-3">
                                        <strong class="text-muted">Quick Actions:</strong>
                                        <div class="d-grid gap-2 mt-2">
                                            <a href="{{ route('settings.email-templates.edit', $mailTemplate) }}" 
                                               class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-edit me-1"></i> Edit Template
                                            </a>
                                            
                                            <form method="POST" 
                                                  action="{{ route('settings.email-templates.toggle-status', $mailTemplate) }}" 
                                                  class="d-inline toggle-status-form" 
                                                  data-action="{{ $mailTemplate->is_active ? 'deactivate' : 'activate' }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-outline-warning btn-sm w-100">
                                                    <i class="fas fa-{{ $mailTemplate->is_active ? 'pause' : 'play' }} me-1"></i>
                                                    {{ $mailTemplate->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            <form method="POST" 
                                                  action="{{ route('settings.email-templates.destroy', $mailTemplate) }}" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this template? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm w-100">
                                                    <i class="fas fa-trash me-1"></i> Delete Template
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Email Preview - {{ $mailTemplate->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Raw HTML Code:</h6>
                        <div class="p-3 bg-dark text-light rounded" style="max-height: 500px; overflow-y: auto;">
                            <pre class="mb-0 text-light"><code>{{ $mailTemplate->body }}</code></pre>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Rendered Preview:</h6>
                        <div class="border rounded p-3" style="max-height: 500px; overflow-y: auto;">
                            <div class="mb-3">
                                <strong>Subject:</strong> {{ $mailTemplate->subject }}
                            </div>
                            <hr>
                            <div id="preview-body">
                                {!! $mailTemplate->body !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($mailTemplate->variables && count($mailTemplate->variables) > 0)
                <div class="mt-4">
                    <h6>Variable Testing:</h6>
                    <div class="alert alert-info">
                        <strong>Available Variables:</strong>
                        @foreach($mailTemplate->variables as $variable)
                            <code class="ms-2">@{{ $variable }}</code>
                        @endforeach
                    </div>
                    <small class="text-muted">
                        In actual emails, these variables will be replaced with real data.
                    </small>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('settings.email-templates.edit', $mailTemplate) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Template
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showPreview() {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

// Syntax highlighting for code blocks
document.addEventListener('DOMContentLoaded', function() {
    // Add some basic syntax highlighting to the HTML preview
    const codeElements = document.querySelectorAll('pre code');
    codeElements.forEach(function(element) {
        // Basic HTML tag highlighting
        let html = element.innerHTML;
        html = html.replace(/(&lt;[^&gt;]*&gt;)/g, '<span style="color: #e74c3c;">$1</span>');
        html = html.replace(/(\{\{[^\}]*\}\})/g, '<span style="color: #f39c12; font-weight: bold;">$1</span>');
        element.innerHTML = html;
    });

    // Handle toggle status form submission
    const toggleForm = document.querySelector('.toggle-status-form');
    if (toggleForm) {
        toggleForm.addEventListener('submit', function(e) {
            const action = this.getAttribute('data-action');
            const message = `Are you sure you want to ${action} this template?`;
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection