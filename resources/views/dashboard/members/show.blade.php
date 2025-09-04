@extends('layouts.dashboard')

@section('styles')
   <link rel="stylesheet" href="{{asset('css/memberProfile.css')}}?v={{ rand(1, 1000000) }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Member Profile Header -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body row">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col-3 d-flex align-items-center">              
                                <div class="avatar-wrapper me-3">
                                    @if($member->profile_photo)
                                <img src="{{ Storage::url($member->profile_photo) }}" alt="Profile Photo" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                              @else
                                <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                              @endif
                                </div>
                                <div>
                                    <h4 class="mb-1">{{ $member->name }}</h4>
                                    <p class="text-muted mb-0">{{ $member->designation }}</p>
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <div class="avatar-wrapper me-3">
                                    @if($member->company_logo)
                                <img src="{{ Storage::url($member->company_logo) }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                              @else
                                <img src="{{ asset('images/default_company.png') }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                              @endif
                                </div>
                                <div class=" me-2">
                                    <h4 class="mb-1">{{ $member->company_name }}</h4>
                                </div>
                            </div>
                            <div class="col-5 d-flex gap-2 justify-content-end">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-{{ $member->status === 'approved' ? 'success' : ($member->status === 'cancelled' ? 'danger' : ($member->status === 'suspended' ? 'dark' : 'warning')) }} dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown">
                                        Status: {{ ucfirst($member->status) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($member->status === 'pending')
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle me-2 text-success"></i>Set as Approved
                                                </button>
                                            </form>
                                        </li>
                                        @elseif($member->status === 'approved')
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-clock me-2 text-warning"></i>Set as Pending
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="suspended">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-pause-circle me-2 text-dark"></i>Set as Suspended
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#cancelMembershipModal">
                                                <i class="bi bi-x-circle me-2"></i>Cancel Membership
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#renewMembershipModal">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Renew Membership
                                            </button>
                                        </li>
                                        @elseif($member->status === 'suspended')
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle me-2 text-success"></i>Reactivate Account
                                                </button>
                                            </form>
                                        </li>
                                        @elseif($member->status === 'cancelled')
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle me-2 text-success"></i>Approve Member
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @if($member->status === 'approved')
                                <a href="{{ route('members.edit', $member) }}" class="btn  btn-outline-secondary ">Edit Details</a>
                                @endif
                                <a href="{{ route('members.index') }}" class="btn  btn-outline-secondary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Details -->
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="mb-0 fs-5">Member Information</p>
                    </div>
                    <div class="card-body p-0">
                        <!-- Contact Information -->
                        <div class="info-section">
                            <div class="info-header">
                                <p class="text-uppercase mb-0 fs-6"><i class="bi bi-person me-2"></i>Contact Information</p>
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
                                <p class="text-uppercase mb-0 fs-6"><i class="bi bi-building me-2"></i>Company Information</p>
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
                                        <span
                                            class="info-value">{{ $member->incorporation_date ? date('F j, Y', strtotime($member->incorporation_date)) : '-' }}</span>
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
                                                @foreach ($specializations as $specialization)
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
                                <p class="text-uppercase mb-0 fs-6"><i class="bi bi-globe me-2"></i>Network Information</p>
                            </div>
                            <div class="info-body">
                                <div class="info-grid">
                                    <div class="info-item full-width">
                                        <span class="info-label">Member of Other Network</span>
                                        <span class="info-value">
                                            {{ ucfirst($member->is_network_member) }}
                                            @if ($member->is_network_member === 'yes')
                                                - {{ $member->network_name }}
                                            @endif
                                        </span>
                                    </div>
                                    @if ($member->referred_by)
                                        <div class="info-item full-width">
                                            <span class="info-label">Referred By</span>
                                            <span class="info-value">{{ $member->referredBy->name ?? '' }}</span>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="mb-0 fs-5">Membership Details</p>
                        @if($member->status === 'approved' && auth()->user()->role == \App\Models\User::SUPER_ADMIN)
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#allocatePointsModal">
                            <i class="bi bi-award me-2"></i>Allocate Signup Points
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex row">
                            <div class="mb-4 col-6">
                               <span class="info-label d-block">Current Tier</span>
                                <div class="d-flex align-items-center">
                               <span class="info-value">
                                        {{ optional($member->membershipTier)->name ?? 'No Tier' }}</span>
                                </div>
                            </div>
                            <div class="mb-4 col-6">
                                 <span class="info-label d-block">CREDIT Protection</span>
                              <span class="info-value">{{ optional($member->membershipTier)->credit_protection ?? 'No credit protection available' }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex row">
                            <div class="mb-4 col-6">
                                   <span class="info-label d-block ">Reward Points</span>
                                   <span class="info-value text-primary">{{ $totalPoints ?? 0 }} pts</span>
                            </div>
                            @if($member->membership_number)
                                <div class="mb-4 col-6">
                                   <span class="info-label d-block">Membership No.</span>
                                  <span class="info-value">{{ $member->membership_number }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex row">
                        <div class="mb-4 col-6">
                            <label class="form-label text-muted mb-2">Member Since</label>
                            <p class="mb-0">{{ $member->created_at->format('F j, Y') }}</p>
                        </div>
                        @if($member->membership_expires_at)
                            <div class="mb-4 col-6">
                               <span class="info-label d-block">Valid Till</span>
                                   <span class="info-value">{{ $member->membership_expires_at->format('F j, Y') }}</span>
                            </div>
                            @endif
                        </div>
                        @if ($member->membershipTier)
                            <div>
                                 <span class="info-label d-block">Tier Benefits</span>
                                 
                                @if($member->membershipTier->benefits && $member->membershipTier->benefits->count() > 0)
                                    <ul class="list-unstyled mb-0 mt-2">
                                        @foreach ($member->membershipTier->benefits as $benefit)
                                            <li class="mb-2 d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                {{ $benefit->title }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mt-2 mb-0">No tier benefits found</p>
                                @endif
                            </div>
                        @endif

                       
                       
                    </div>
                </div>
                   <div class="col-12">
                           <div class="mt-4 card bg-white p-3">

                            <span class="info-label d-block">About Company</span>
                            @if($member->company_description)
                                <div class="company-description">
                                    {!! $member->company_description !!}
                                </div>
                            @else
                                <p class="text-muted mb-0">Nothing about company</p>
                            @endif
                      




                           </div>
                        </div>

                                <div class="col-12">


 @if($member->certificate_document)
                      <div class="mt-4 card bg-white p-3">
                          <span class="info-label d-block">E-certificate</span>
                            <div class="e-certificate-section">
                                <div class="gradient_rounded radies_20">
                                    <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                        <!-- Certificate Image Display - Clickable for Preview -->
                                        <div class="certificate-preview mb-3" style="border-radius: 10px; padding: 10px; background: rgba(255, 255, 255, 0.1); cursor: pointer;">
                                            <a href="{{ Storage::url($member->certificate_document) }}" 
                                               target="_blank"
                                               style="text-decoration: none; display: block;">
                                                <img src="{{ Storage::url($member->certificate_document) }}" 
                                                     alt="E-Certificate - Click to Preview" 
                                                     class="img-fluid rounded"
                                                     style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px; transition: all 0.3s ease;"
                                                     onmouseover="this.style.transform='scale(1.05)'"
                                                     onmouseout="this.style.transform='scale(1)'">
                                            </a>
                                        </div>
                                        @if($member->certificate_uploaded_at)
                                        <small class="text-muted mt-1">
                                            Last updated: {{ $member->certificate_uploaded_at->format('M d, Y') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif





                           
                        </div>
            </div>
            
            <!-- Member Logs Section -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Member Activity Logs</h5>
                        <small class="text-muted">Track all membership changes and administrative actions</small>
                    </div>
                    <div class="card-body">
                        @if($membershipLogs->count() > 0)
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-striped table-sm">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th width="12%">Action</th>
                                            <th width="8%">Status</th>
                                            <th width="12%">Tier Change</th>
                                            <th width="12%">Membership No.</th>
                                            <th width="10%">Annual Fee</th>
                                            <th width="10%">Valid Until</th>
                                            <th width="8%">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($membershipLogs as $log)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-{{ 
                                                            $log->action === 'approve' ? 'check-circle-fill text-success' : (
                                                            $log->action === 'update' ? 'pencil-fill text-primary' : (
                                                            $log->action === 'change_tier' ? 'arrow-up-circle-fill text-info' : (
                                                            $log->action === 'renewal' ? 'arrow-clockwise text-info' : (
                                                            $log->action === 'cancelled' ? 'x-circle-fill text-danger' : (
                                                            $log->action === 'renewed' ? 'arrow-clockwise text-success' : (
                                                            $log->action === 'early_renewal' ? 'lightning-fill text-warning' : 'info-circle-fill text-secondary'
                                                            ))))))
                                                        }} me-2"></i>
                                                        <span class="fw-medium">{{ $log->action_label }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $log->status_badge_class }}">{{ $log->status_label }}</span>
                                                </td>
                                                <td>
                                                    @if($log->previous_tier_name && $log->new_tier_name && $log->previous_tier_name !== $log->new_tier_name)
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            <span class="badge bg-light text-dark me-1">{{ $log->previous_tier_name }}</span>
                                                            <i class="bi bi-arrow-right me-1"></i>
                                                            <span class="badge bg-light text-dark">{{ $log->new_tier_name }}</span>
                                                        </div>
                                                    @elseif($log->new_tier_name)
                                                        <span class="badge bg-light text-dark ">{{ $log->new_tier_name }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->new_membership_number && $log->new_membership_number !== 'N/A')
                                                        <span class="small">{{ $log->new_membership_number }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->formatted_new_annual_fee)
                                                        <strong class="small">{{ $log->formatted_new_annual_fee }}</strong>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->new_expiry_date)
                                                        <span class="small">{{ $log->new_expiry_date->format('d M Y') }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="small text-muted">{{ $log->created_at->format('d M Y H:i') }}</span>
                                                </td>
                                            </tr>
                                            @if(($log->isEarlyRenewal() && $log->original_expiry_date) || $log->reason)
                                                <tr class="table-light">
                                                    <td colspan="8">
                                                        <div class="small text-muted ps-3">
                                                            @if($log->isEarlyRenewal() && $log->original_expiry_date)
                                                                <div><strong>Early Renewal:</strong> Extended from original expiry date {{ $log->original_expiry_date->format('M j, Y') }}</div>
                                                            @endif
                                                            @if($log->reason && $log->reason !== 'Membership renewed by admin')
                                                                <div><strong>Reason:</strong> {{ $log->reason }}</div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No Activity Logs</h5>
                                <p class="text-muted">No membership changes or administrative actions have been recorded for this member yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <div class="position-fixed bottom-0 end-0 p-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left" style="font-size: 15px;"></i>
                <span class="d-none d-md-inline">Back</span>
            </a>
        </div>
    </div>

    <!-- Cancel Membership Modal -->
    <div class="modal fade" id="cancelMembershipModal" tabindex="-1" aria-labelledby="cancelMembershipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="cancelMembershipModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Cancel Membership
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('members.cancel-membership', $member) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to cancel this member's membership? This action will:</p>
                        <ul class="text-danger">
                            <li>Set their status to cancelled</li>
                            <li>Deactivate their access to the website</li>
                            <li>Log the cancellation with reason</li>
                        </ul>
                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label">Cancellation Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('cancellation_reason') is-invalid @enderror" 
                                      id="cancellation_reason" name="cancellation_reason" rows="3" 
                                      placeholder="Please provide a reason for cancellation..." required></textarea>
                            @error('cancellation_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i>Cancel Membership
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Renew Membership Modal -->
    <div class="modal fade" id="renewMembershipModal" tabindex="-1" aria-labelledby="renewMembershipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="renewMembershipModalLabel">
                        <i class="bi bi-arrow-clockwise me-2"></i>Renew Membership
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('members.renew-membership', $member) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Membership Status Check -->
                        <div id="membershipStatusCheck">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Checking membership status...</span>
                                </div>
                                <span class="ms-2">Checking membership status...</span>
                            </div>
                        </div>
                        
                        <!-- Membership Information (initially hidden) -->
                        <div id="membershipInfo" style="display: none;">
                            <!-- Status Alert -->
                            <div id="statusAlert" class="alert mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i id="statusIcon" class="me-2"></i>
                                    <div>
                                        <strong id="statusTitle"></strong>
                                        <div id="statusMessage" class="small"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Current Membership Information -->
                            <div class="card border-0 shadow-sm mb-3">
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
                                                <small class="text-muted mb-1">Days Until Expiry</small>
                                                @if($member->membership_expires_at)
                                                    @php
                                                        $expiryDate = \Carbon\Carbon::parse($member->membership_expires_at);
                                                        $isExpired = $expiryDate->isPast();
                                                        $daysRemaining = (int) abs($expiryDate->diffInDays(utcNow()));
                                                    @endphp
                                                    @if(!$isExpired)
                                                        <span class="badge bg-success">{{ $daysRemaining }} days remaining</span>
                                                    @elseif($daysRemaining == 0)
                                                        @if($isExpired)
                                                        <span class="badge bg-warning">Expired</span>
                                                        @else
                                                        <span class="badge bg-warning">Expires today</span>

                                                        @endif
                                                    @else
                                                        <span class="badge bg-danger">Expired {{ $daysRemaining }} days ago</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Not Set</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <small class="text-muted mb-1">
                                                    <i class="bi bi-calendar-event me-1"></i>Start Date
                                                </small>
                                                <span class="fw-semibold">
                                                    {{ $member->membership_start_at ? date('M j, Y', strtotime($member->membership_start_at)) : 'Not Set' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <small class="text-muted mb-1">
                                                    <i class="bi bi-calendar-x me-1"></i>Expiry Date
                                                </small>
                                                <span class="fw-semibold" id="expiryDate">
                                                    {{ $member->membership_expires_at ? date('M j, Y', strtotime($member->membership_expires_at)) : 'Not Set' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer" id="modalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="renewButton" style="display: none;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Renew Membership
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Allocate Signup Points Modal -->
    <div class="modal fade" id="allocatePointsModal" tabindex="-1" aria-labelledby="allocatePointsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="allocatePointsModalLabel">
                        <i class="bi bi-award me-2"></i>Allocate Signup Reward Points
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('members.allocate-points', $member) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="points" class="form-label">Points to Allocate <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                   id="points" name="points" min="1" max="1000" 
                                   placeholder="Enter points (1-1000)" required>
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Enter the number of signup reward points to allocate to this member.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" name="reason" rows="3" 
                                      placeholder="Please provide a reason for allocating these points..." required></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-award me-2"></i>Allocate Points
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle renewal modal show event
    const renewModal = document.getElementById('renewMembershipModal');
    if (renewModal) {
        renewModal.addEventListener('show.bs.modal', function() {
            checkMembershipStatus();
        });
    }
    
    function checkMembershipStatus() {
        // Get member data from PHP
        const memberData = {
            status: '{{ $member->status }}',
            membership_expires_at: '{{ $member->membership_expires_at }}',
            membership_start_at: '{{ $member->membership_start_at }}',
            tier_name: '{{ $member->membershipTier->name ?? "N/A" }}'
        };
        
        // Simulate checking process
        setTimeout(() => {
            // Hide loading spinner
            document.getElementById('membershipStatusCheck').style.display = 'none';
            
            // Show membership info
            document.getElementById('membershipInfo').style.display = 'block';
            
            // Determine membership status
            const now = new Date();
            const expiryDate = memberData.membership_expires_at ? new Date(memberData.membership_expires_at) : null;
            const isExpired = expiryDate && expiryDate < now;
            const isActive = memberData.status === 'approved' && !isExpired;
            const isCancelled = memberData.status === 'cancelled';
            
            // Update status alert
            updateStatusAlert(memberData.status, isExpired, isActive, isCancelled);
            
            // Show/hide renewal button and info based on status
            if (isActive && !isExpired) {
                // Active membership - show warning about early renewal
                showRenewalWarning();
            } else if (isExpired || isCancelled) {
                // Expired or cancelled - allow renewal
                showRenewalAllowed();
            } else {
                // Pending or other status - block renewal
                showRenewalBlocked();
            }
        }, 1500); // Simulate loading time
    }
    
    function updateStatusAlert(status, isExpired, isActive, isCancelled) {
        const alert = document.getElementById('statusAlert');
        const icon = document.getElementById('statusIcon');
        const title = document.getElementById('statusTitle');
        const message = document.getElementById('statusMessage');
        
        if (isActive && !isExpired) {
            alert.className = 'alert alert-success mb-3';
            icon.className = 'bi bi-check-circle-fill me-2';
            title.textContent = 'Active Membership';
            message.textContent = 'This member has an active membership plan.';
        } else if (isExpired) {
            alert.className = 'alert alert-warning mb-3';
            icon.className = 'bi bi-exclamation-triangle-fill me-2';
            title.textContent = 'Expired Membership';
            message.textContent = 'This membership has expired and needs renewal.';
        } else if (isCancelled) {
            alert.className = 'alert alert-danger mb-3';
            icon.className = 'bi bi-x-circle-fill me-2';
            title.textContent = 'Cancelled Membership';
            message.textContent = 'This membership has been cancelled and can be renewed.';
        } else {
            alert.className = 'alert alert-info mb-3';
            icon.className = 'bi bi-info-circle-fill me-2';
            title.textContent = 'Pending Membership';
            message.textContent = 'This membership is pending approval.';
        }
    }
    
    function showRenewalWarning() {
        const renewButton = document.getElementById('renewButton');
        
        renewButton.style.display = 'inline-block';
        renewButton.className = 'btn btn-warning';
        renewButton.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Renew Early';
    }
    
    function showRenewalAllowed() {
        const renewButton = document.getElementById('renewButton');
        
        renewButton.style.display = 'inline-block';
        renewButton.className = 'btn btn-success';
        renewButton.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Renew Membership';
    }
    
    function showRenewalBlocked() {
        const renewButton = document.getElementById('renewButton');
        
        renewButton.style.display = 'none';
        
        // Add blocked message
        const modalFooter = document.getElementById('modalFooter');
        const existingMessage = modalFooter.querySelector('.renewal-blocked-message');
        if (!existingMessage) {
            const blockedMessage = document.createElement('div');
            blockedMessage.className = 'renewal-blocked-message alert alert-info mb-0 me-2';
            blockedMessage.innerHTML = '<small><i class="bi bi-info-circle me-1"></i>Renewal is not available for pending memberships.</small>';
            modalFooter.insertBefore(blockedMessage, modalFooter.firstChild);
        }
    }
});
</script>
@endsection
