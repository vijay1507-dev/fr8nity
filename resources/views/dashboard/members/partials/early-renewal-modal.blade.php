<!-- Early Renewal Modal -->
<div class="modal fade" id="earlyRenewalModal" tabindex="-1" aria-labelledby="earlyRenewalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="earlyRenewalModalLabel">
                    <i class="bi bi-lightning-fill me-2"></i>Early Renewal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('members.early-renewal', $member) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Early Renewal Information -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div>
                                <strong>Early Renewal Benefits:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Membership will be extended from the current expiry date</li>
                                    <li>No loss of remaining membership time</li>
                                    <li>Continuous membership benefits</li>
                                    <li>Avoid potential service interruptions</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Current Membership Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Current Membership Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">Membership Tier</small>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">{{ $member->membershipTier->name ?? 'N/A' }}</span>
                                            <small class="text-muted">#{{ $member->membership_number ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">Current Expiry Date</small>
                                        <span class="fw-semibold">
                                            {{ $member->membership_expires_at ? $member->membership_expires_at->format('M j, Y') : 'Not Set' }}
                                        </span>
                                        @if($member->membership_expires_at)
                                            @php
                                                $daysRemaining = \utcNow()->diffInDays($member->membership_expires_at, false);
                                                $isExpired = $daysRemaining < 0;
                                            @endphp
                                            @if(!$isExpired)
                                                <small class="text-success">{{ $daysRemaining }} days remaining</small>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">Annual Fee</small>
                                        <span class="fw-semibold">
                                            @php
                                                $annualFee = $member->membershipTier->annual_fee ?? 0;
                                                $annualFee = is_numeric($annualFee) ? (float)$annualFee : 0;
                                            @endphp
                                            {{ $member->membershipTier->annual_fee_currency ?? 'USD' }} {{ number_format($annualFee, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">New Expiry Date (After Early Renewal)</small>
                                        @php
                                            $currentExpiry = $member->membership_expires_at ? \Carbon\Carbon::parse($member->membership_expires_at) : \utcNow();
                                            $newExpiry = $member->membershipTier && $member->membershipTier->name === 'Pinnacle' 
                                                ? $currentExpiry->copy()->addYears(3) 
                                                : $currentExpiry->copy()->addYear();
                                        @endphp
                                        <span class="fw-semibold text-success">
                                            {{ $newExpiry->format('M j, Y') }}
                                        </span>
                                        <small class="text-muted">Extended by {{ $member->membershipTier && $member->membershipTier->name === 'Pinnacle' ? '3 years' : '1 year' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Early Renewal Form -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="early_renewal_reason" class="form-label">
                                <i class="bi bi-chat-quote me-1"></i>Reason for Early Renewal <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="early_renewal_reason" name="early_renewal_reason" rows="3" 
                                placeholder="Please provide a reason for processing early renewal..." required></textarea>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-lightning-fill me-2"></i>Process Early Renewal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
