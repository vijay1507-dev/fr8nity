@extends('layouts.dashboard')

@section('title', 'Create New Membership Tier')

@section('content')
<main class="content px-3 py-4">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-semibold mb-0">Create New Membership Tier</h4>
                <p class="text-muted mb-0">Add a new membership tier with benefits and rewards</p>
            </div>
            <div>
                <a href="{{ route('membership-tiers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Tiers
                </a>
            </div>
        </div>

        <!-- Create Form -->
        <div class="dashboard-card">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="mb-0">Tier Information</h5>
            </div>
            <div class="card-body p-4">
                <form id="createTierForm" method="POST" action="{{ route('membership-tiers.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3 text-primary">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', App\Models\MembershipTier::getNextOrder()) }}" 
                                   min="1" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="annual_fee" class="form-label">Annual Fee</label>
                            <input type="text" class="form-control @error('annual_fee') is-invalid @enderror" 
                                   id="annual_fee" name="annual_fee" value="{{ old('annual_fee') }}" 
                                   placeholder="e.g., $1,900">
                            @error('annual_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="credit_protection" class="form-label">Credit Protection <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('credit_protection') is-invalid @enderror" 
                                   id="credit_protection" name="credit_protection" value="{{ old('credit_protection') }}" 
                                   placeholder="e.g., Up to USD $5,000/year" required>
                            @error('credit_protection')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Settings -->
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3 text-primary">Status Settings</h6>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                       value="1" {{ old('is_active', 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Tier
                                </label>
                            </div>
                            
                            <small class="text-muted">Active tiers can be assigned to new members</small>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_visible" value="0">
                                <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible"
                                       value="1" {{ old('is_visible', 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_visible">
                                    Visible to Public
                                </label>
                            </div>
                            <small class="text-muted">Visible tiers appear on the public website</small>
                        </div>

                        <!-- Benefits Assignment -->
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3 text-primary">Benefits Assignment</h6>
                            <p class="text-muted mb-3">Select the benefits that will be available to this tier</p>
                            
                            <div class="row g-3" id="benefitsContainer">
                                @forelse($benefits as $benefit)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="benefits[]" value="{{ $benefit->id }}" 
                                               id="benefit_{{ $benefit->id }}">
                                        <label class="form-check-label" for="benefit_{{ $benefit->id }}">
                                            <strong>{{ $benefit->title }}</strong>
                                            @if($benefit->description)
                                                <br><small class="text-muted">{{ Str::limit($benefit->description, 60) }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No benefits available. 
                                        <a href="{{ route('membership-benefits.create') }}" class="alert-link">Create some benefits first</a>.
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Rewards Configuration -->
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3 text-primary">{{ __('translation.rewards_configuration') }}</h6>
                            <p class="text-muted mb-3">{{ __('translation.configure_reward_points') }}</p>
                            
                            <div id="rewardsContainer">
                                @php
                                    $defaultActivityTypes = [
                                        'referral_join',
                                        'business_collaboration_50_1k',
                                        'business_collaboration_1k_5k',
                                        'business_collaboration_5k_25k',
                                        'business_collaboration_25k_100k',
                                        'business_collaboration_above_100k'
                                    ];
                                @endphp
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40%;">{{ __('translation.activity_type') }}</th>
                                                <th style="width: 30%;">{{ __('translation.points') }}</th>
                                                <th style="width: 30%;">{{ __('translation.multiplier') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($defaultActivityTypes as $index => $activityType)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="rewards[{{ $index }}][activity_type]" value="{{ $activityType }}">
                                                    <span class="fw-medium">{{ __('translation.' . $activityType) }}</span>
                                                    <br><small class="text-muted">{{ $activityType }}</small>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="rewards[{{ $index }}][points]" 
                                                           value="0" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="rewards[{{ $index }}][multiplier]" 
                                                           value="1.00" min="0.01" max="10.00" step="0.01">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- <button type="button" class="btn btn-outline-primary btn-sm" onclick="addReward()">
                                Add Reward
                            </button> -->
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-center gap-2 mt-4 pt-4 border-top">
                        <a href="{{ route('membership-tiers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Create Tier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
let rewardCounter = 0;

function addReward() {
    const container = document.getElementById('rewardsContainer');
    const newReward = document.createElement('div');
    newReward.className = 'reward-item border rounded p-3 mb-3';
    newReward.innerHTML = `
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Activity Type</label>
                <input type="text" class="form-control" name="rewards[${rewardCounter}][activity_type]" 
                       placeholder="e.g., referral_join, event_attendance">
            </div>
            <div class="col-md-3">
                <label class="form-label">Points</label>
                <input type="number" class="form-control" name="rewards[${rewardCounter}][points]" 
                       placeholder="1000" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Multiplier</label>
                <input type="number" class="form-control" name="rewards[${rewardCounter}][multiplier]" 
                       placeholder="1.00" min="0.01" max="10.00" step="0.01" value="1.00">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-reward" 
                        onclick="removeReward(this)">
                    Remove
                </button>
            </div>
        </div>
    `;
    container.appendChild(newReward);
    rewardCounter++;
}

function removeReward(button) {
    button.closest('.reward-item').remove();
}

// Remove validation styling on input
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});

// Initialize reward counter properly
document.addEventListener('DOMContentLoaded', function() {
    // Set reward counter to the maximum index + 1
    const existingRewards = document.querySelectorAll('.reward-item');
    if (existingRewards.length > 0) {
        rewardCounter = existingRewards.length;
    } else {
        rewardCounter = 0;
    }
});
</script>
@endsection