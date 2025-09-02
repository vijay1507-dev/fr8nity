@extends('layouts.dashboard')

@section('title', 'View Membership Tier')

@section('content')
<main class="content px-3 py-4">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-semibold mb-0">{{ $membershipTier->name }}</h4>
                <p class="text-muted mb-0">Membership Tier Details</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('membership-tiers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Tiers
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Basic Information -->
            <div class="col-12 col-lg-8">
                <div class="dashboard-card">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Tier Name</label>
                                <p class="mb-0 fs-5">{{ $membershipTier->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Slug</label>
                                <p class="mb-0 fs-6 text-muted">{{ $membershipTier->slug }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Annual Fee</label>
                                <p class="mb-0 fs-5 fw-semibold">{{ $membershipTier->formatted_annual_fee }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Credit Protection</label>
                                <p class="mb-0 fs-6">{{ $membershipTier->credit_protection }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $membershipTier->is_active ? 'success' : 'danger' }} me-2">
                                        {{ $membershipTier->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="badge bg-{{ $membershipTier->is_visible ? 'info' : 'secondary' }}">
                                        {{ $membershipTier->is_visible ? 'Visible' : 'Hidden' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Order</label>
                                <p class="mb-0 fs-6">{{ $membershipTier->order }}</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted">Description</label>
                                <p class="mb-0">{{ $membershipTier->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rewards -->
                <div class="dashboard-card mt-4">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0">{{ __('translation.rewards_configuration') }}</h5>
                        <small class="text-muted">{{ $membershipTier->rewards->count() }} reward types</small>
                    </div>
                    <div class="card-body px-4">
                        @if($membershipTier->rewards->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('translation.activity_type') }}</th>
                                            <th>{{ __('translation.points') }}</th>
                                            <th>{{ __('translation.multiplier') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($membershipTier->rewards as $reward)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold">{{ __('translation.' . $reward->activity_type) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ number_format($reward->points) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">× {{ $reward->multiplier }}</span>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No rewards configured</h6>
                                <p class="text-muted mb-0">This tier doesn't have any reward points configured yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4">
                <!-- Benefits -->
                <div class="dashboard-card mb-4">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0">TIER BENEFITS</h5>
                        <small class="text-muted">{{ $membershipTier->benefits->count() }} benefits assigned</small>
                    </div>
                    <div class="card-body p-4">
                        @if($membershipTier->benefits->count() > 0)
                            <div class="list-unstyled mb-0">
                                @foreach($membershipTier->benefits as $benefit)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-dark">{{ $benefit->title }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No benefits assigned</h6>
                                <p class="text-muted mb-0">This tier doesn't have any benefits assigned yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the membership tier "<strong id="tierName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone and will remove all associated benefits and rewards.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Tier</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let tierToDelete = null;

function deleteTier(tierId, tierName) {
    tierToDelete = tierId;
    document.getElementById('tierName').textContent = tierName;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!tierToDelete) return;
    
    fetch(`/membership-tiers/${tierToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Success', data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            setTimeout(() => {
                window.location.href = '{{ route("membership-tiers.index") }}';
            }, 1000);
        } else {
            showToast('Error', data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Error', 'An error occurred while deleting the tier', 'error');
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
