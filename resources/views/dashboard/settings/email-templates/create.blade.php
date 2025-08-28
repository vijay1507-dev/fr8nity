@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Email Template</h5>
                    <a href="{{ route('settings.email-templates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Templates
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('settings.email-templates.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="e.g., welcome-email, password-reset"
                                       required>
                                <div class="form-text">Use a unique, descriptive name for this template</div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                                <div class="form-text">Only active templates can be used for sending emails</div>
                            </div>

                            <div class="col-12">
                                <label for="subject" class="form-label">Email Subject <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}" 
                                       placeholder="Enter email subject line"
                                       required>
                                <div class="form-text">You can use variables like @{{name}}, @{{company}} in the subject</div>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="body" class="form-label">Email Body <span class="text-danger">*</span></label>
                                <div id="body-editor" style="height: 300px;"></div>
                                <textarea id="body" name="body" class="d-none @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
                                <div class="form-text">
                                    Use HTML for formatting. Variables can be used like @{{name}}, @{{email}}, @{{company}}, etc.
                                </div>
                                @error('body')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="variables" class="form-label">Available Variables</label>
                                <textarea class="form-control @error('variables') is-invalid @enderror" 
                                          id="variables" 
                                          name="variables" 
                                          rows="6" 
                                          placeholder="Enter one variable per line&#10;name&#10;email&#10;company&#10;membership_tier">{{ old('variables') }}</textarea>
                                <div class="form-text">List variables that can be used in this template (one per line)</div>
                                @error('variables')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="comment" class="form-label">Comments/Notes</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" 
                                          id="comment" 
                                          name="comment" 
                                          rows="6" 
                                          placeholder="Add any notes or comments about this template...">{{ old('comment') }}</textarea>
                                <div class="form-text">Optional description or usage notes for this template</div>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Template
                            </button>
                            <a href="{{ route('settings.email-templates.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Email Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject:</label>
                    <div id="preview-subject" class="p-2 bg-light rounded"></div>
                </div>
                <div>
                    <label class="form-label fw-bold">Body:</label>
                    <div id="preview-body" class="p-3 border rounded" style="min-height: 300px; max-height: 400px; overflow-y: auto;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    const quill = new Quill('#body-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Enter your email template content here...'
    });

    // Get existing content and set it in Quill
    const existingContent = document.getElementById('body').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Update hidden textarea when Quill content changes
    quill.on('text-change', function() {
        document.getElementById('body').value = quill.root.innerHTML;
    });

    // Add preview functionality
    const previewBtn = document.createElement('button');
    previewBtn.type = 'button';
    previewBtn.className = 'btn btn-outline-info';
    previewBtn.innerHTML = '<i class="fas fa-eye me-1"></i> Preview';
    previewBtn.onclick = showPreview;
    
    // Add preview button to the form actions
    const formActions = document.querySelector('.d-flex.justify-content-center');
    if (formActions) {
        formActions.insertBefore(previewBtn, formActions.firstChild);
    }

    function showPreview() {
        const subject = document.getElementById('subject').value || 'No subject';
        const body = quill.root.innerHTML || 'No content';
        
        document.getElementById('preview-subject').textContent = subject;
        document.getElementById('preview-body').innerHTML = body;
        
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    }

    // Auto-generate template name from subject
    const subjectInput = document.getElementById('subject');
    const nameInput = document.getElementById('name');
    
    subjectInput.addEventListener('input', function() {
        if (!nameInput.value) {
            const generatedName = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s]/g, '')
                .replace(/\s+/g, '-')
                .substring(0, 50);
            nameInput.value = generatedName;
        }
    });
});
</script>
@endsection