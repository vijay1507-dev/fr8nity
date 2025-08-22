@extends('layouts.dashboard')

@section('title', 'Edit Membership Benefit')

@section('content')
<main class="content px-3 py-4">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-semibold mb-0">Edit Membership Benefit</h4>
                <p class="text-muted mb-0">Update benefit information</p>
            </div>
            <div>
                <a href="{{ route('membership-benefits.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Benefits
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="dashboard-card">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="mb-0">Benefit Information</h5>
            </div>
            <div class="card-body p-4">
                <form id="editBenefitForm" method="POST" action="{{ route('membership-benefits.update', $membershipBenefit) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Benefit Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $membershipBenefit->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">A clear, descriptive title for the benefit</small>
                        </div>

                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $membershipBenefit->sort_order) }}" 
                                   min="1" required>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Lower numbers appear first</small>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $membershipBenefit->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Optional detailed description of the benefit</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                       value="1" {{ old('is_active', $membershipBenefit->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Benefit
                                </label>
                            </div>
                            
                            <small class="text-muted">Active benefits can be assigned to membership tiers</small>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-center gap-2 mt-4 pt-4 border-top">
                        <a href="{{ route('membership-benefits.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Update Benefit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Form submission handling
document.getElementById('editBenefitForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Success', data.message, 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showToast('Error', 'Please check the form for errors', 'error');
            // Handle validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = data.errors[field][0];
                        }
                    }
                });
            }
        }
    })
    .catch(error => {
        showToast('Error', 'An error occurred while updating the benefit', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Remove validation styling on input
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});

function showToast(title, message, type) {
    switch(type) {
        case 'success':
            toastr.success(message, title);
            break;
        case 'error':
            toastr.error(message, title);
            break;
        case 'warning':
            toastr.warning(message, title);
            break;
        case 'info':
            toastr.info(message, title);
            break;
        default:
            toastr.info(message, title);
    }
}
</script>
@endpush
