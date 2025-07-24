@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Member Profile Header -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $member->name }}</h4>
                                <p class="text-muted mb-0">{{ $member->designation }}</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-{{ $member->status === 'approved' ? 'success' : 'warning' }} dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Status: {{ ucfirst($member->status) }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('members.update-status', $member) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="dropdown-item">Set as Pending</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('members.update-status', $member) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="dropdown-item">Set as Approved</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Details -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Member Information</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Contact Information -->
                    <div class="info-section">
                        <div class="info-header">
                            <h6 class="text-uppercase mb-0"><i class="bi bi-person me-2"></i>Contact Information</h6>
                        </div>
                        <div class="info-body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Email</span>
                                    <span class="info-value">{{ $member->email }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">WhatsApp/Phone</span>
                                    <span class="info-value">{{ $member->whatsapp_phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="info-section">
                        <div class="info-header">
                            <h6 class="text-uppercase mb-0"><i class="bi bi-building me-2"></i>Company Information</h6>
                        </div>
                        <div class="info-body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Company Name</span>
                                    <span class="info-value">{{ $member->company_name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Company Telephone</span>
                                    <span class="info-value">{{ $member->company_telephone }}</span>
                                </div>
                                <div class="info-item ">
                                    <span class="info-label">Company Address</span>
                                    <span class="info-value">{{ $member->company_address }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Country</span>
                                    <span class="info-value">{{ $member->country->name ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">City</span>
                                    <span class="info-value">{{ $member->city->name ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Region</span>
                                    <span class="info-value">{{ $member->region->name ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tax ID</span>
                                    <span class="info-value">{{ $member->tax_id }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Incorporation Date</span>
                                    <span class="info-value">{{ $member->incorporation_date ? date('F j, Y', strtotime($member->incorporation_date)) : '-' }}</span>
                                </div>
                                <div class="info-item full-width">
                                    <span class="info-label">Website / LinkedIn</span>
                                    <span class="info-value">
                                        <a href="{{ $member->website_linkedin }}" target="_blank" class="text-primary">
                                            {{ $member->website_linkedin }}
                                        </a>
                                    </span>
                                </div>
                                <div class="info-item full-width">
                                    <span class="info-label">Specializations</span>
                                    <span class="info-value">
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $specializations = is_string($member->specializations) 
                                                    ? json_decode($member->specializations) 
                                                    : $member->specializations;
                                            @endphp
                                            @foreach($specializations as $specialization)
                                                <span class="badge bg-primary">{{ $specialization }}</span>
                                            @endforeach
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Network Information -->
                    <div class="info-section">
                        <div class="info-header">
                            <h6 class="text-uppercase mb-0"><i class="bi bi-globe me-2"></i>Network Information</h6>
                        </div>
                        <div class="info-body">
                            <div class="info-grid">
                                <div class="info-item full-width">
                                    <span class="info-label">Member of Other Network</span>
                                    <span class="info-value">
                                        {{ ucfirst($member->is_network_member) }}
                                        @if($member->is_network_member === 'yes')
                                            - {{ $member->network_name }}
                                        @endif
                                    </span>
                                </div>
                                @if($member->referred_by)
                                <div class="info-item full-width">
                                    <span class="info-label">Referred By</span>
                                    <span class="info-value">{{ $member->referred_by }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Membership Information -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Membership Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label text-muted mb-1">Current Tier</label>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 membership-tier-name">{{ optional($member->membershipTier)->name ?? 'No Tier' }}</h4>
                            <button class="btn btn-link ms-2 p-0" data-bs-toggle="modal" data-bs-target="#changeTierModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted mb-2">Member Since</label>
                        <p class="mb-0">{{ $member->created_at->format('F j, Y') }}</p>
                    </div>

                    @if($member->membershipTier)
                    <div>
                        <label class="form-label text-muted mb-2">Tier Benefits</label>
                        <ul class="list-unstyled mb-0">
                            @foreach($member->membershipTier->benefits as $benefit)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    {{ $benefit->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Tier Modal -->
<div class="modal fade" id="changeTierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Membership Tier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateTierForm" action="{{ route('members.update-membership-tier', $member) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select New Tier</label>
                        <select class="form-select" name="membership_tier" required>
                            <option value="">Select a tier</option>
                            @foreach($membershipTiers as $tier)
                                <option value="{{ $tier->id }}" {{ $member->membership_tier == $tier->id ? 'selected' : '' }}>
                                    {{ $tier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Tier</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then load other libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
$(document).ready(function() {
    // Configure toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Show success message if exists in session
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Handle membership tier update form submission
    $('#updateTierForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const modal = $('#changeTierModal');
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();

        // Disable submit button and show loading state
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                // Show success message
                toastr.success('Membership tier updated successfully');
                
                // Get the selected tier name and ID
                const selectedTierOption = form.find('select option:selected');
                const selectedTierName = selectedTierOption.text();
                const selectedTierId = selectedTierOption.val();
                
                // Update the displayed tier name in the card
                $('.membership-tier-name').text(selectedTierName);
                
                // Update the selected option in the modal
                form.find('select option').each(function() {
                    $(this).prop('selected', $(this).val() === selectedTierId);
                });
                
                // Reset button state
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
                
                // Close modal
                modal.modal('hide');
            },
            error: function(xhr) {
                // Show error message
                toastr.error('An error occurred while updating the membership tier');
                
                // Reset button state
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>

<style>
.avatar {
    font-weight: 600;
}
.badge {
    font-weight: 500;
    padding: 6px 12px;
}
.form-label {
    font-size: 0.875rem;
    color: #344767 !important;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.card {
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
}
.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e9ecef;
}
.card-title {
    color: #344767;
    font-weight: 600;
}
.text-muted {
    color: #344767 !important;
    opacity: 0.7;
}
.dropdown-item {
    cursor: pointer;
}
.btn-link {
    color: var(--bs-primary);
}
.btn-link:hover {
    color: var(--bs-primary-dark);
}
h6.text-uppercase {
    color: #344767;
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
p.mb-0 {
    color: #344767;
    font-weight: 500;
}
.badge {
    font-weight: 500;
    padding: 6px 12px;
    font-size: 0.75rem;
}
.modal-title {
    color: #344767;
    font-weight: 600;
}
.list-unstyled li {
    color: #344767;
    font-weight: 500;
}
.avatar {
    background-color: #435ebe !important;
}
.btn-success {
    background-color: #2dce89;
    border-color: #2dce89;
}
.btn-warning {
    background-color: #fb6340;
    border-color: #fb6340;
    color: #fff;
}
.btn-outline-secondary {
    color: #344767;
    border-color: #8392ab;
}
.btn-outline-secondary:hover {
    background-color: #8392ab;
    border-color: #8392ab;
}

/* Member Information Styling */
.info-section {
    border-bottom: 1px solid #e9ecef;
}
.info-section:last-child {
    border-bottom: none;
}
.info-header {
    padding: 1rem 1.5rem;
    background-color: #f8f9fa;
}
.info-header h6 {
    color: #344767;
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}
.info-body {
    padding: 1.5rem;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}
.info-item {
    display: flex;
    flex-direction: column;
}
.info-item.full-width {
    grid-column: 1 / -1;
}
.info-label {
    font-size: 0.75rem;
    color: #8392ab;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    letter-spacing: 0.5px;
}
.info-value {
    color: #344767;
    font-weight: 500;
}
.badge {
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
}
.card {
    border: none;
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
}
.card-header {
    background-color: white;
    border-bottom: none;
}
.text-primary {
    color: #435ebe !important;
}
.bg-primary {
    background-color: #435ebe !important;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    .info-body {
        padding: 1rem;
    }
    .info-header {
        padding: 1rem;
    }
}
</style>
@endsection 