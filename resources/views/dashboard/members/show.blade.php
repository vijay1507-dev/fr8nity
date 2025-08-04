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
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
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
                            <div class="d-flex align-items-center">
                                <div class="avatar-wrapper me-3">
                                    @if($member->company_logo)
                                <img src="{{ Storage::url($member->company_logo) }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                              @else
                                <img src="{{ asset('images/default_company.png') }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                              @endif
                                </div>
                                <div>
                                    <h4 class="mb-1">{{ $member->company_name }}</h4>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-{{ $member->status === 'approved' ? 'success' : 'warning' }} dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown">
                                        Status: {{ ucfirst($member->status) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">Set as Approved</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('members.update-status', $member) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item">Set as Pending</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @if($member->status === 'approved')
                                <a href="{{ route('members.edit', $member) }}" class="btn btn-outline-secondary">Edit Details</a>
                                @endif
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
                                <h6 class="text-uppercase mb-0"><i class="bi bi-globe me-2"></i>Network Information</h6>
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
                    <div class="card-header">
                        <h5 class="card-title mb-0">Membership Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-4">
                                <label class="form-label text-muted mb-1">Current Tier</label>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-0 membership-tier-name">
                                        {{ optional($member->membershipTier)->name ?? 'No Tier' }}</h4>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted mb-2">CREDIT Protection</label>
                                @if($member->membership_tier == 1)
                                <p class="mb-0">USD $5,000/year</p>
                                @elseif($member->membership_tier == 2)
                                <p class="mb-0">USD $8,000/year</p>
                                @elseif($member->membership_tier == 3)
                                <p class="mb-0">USD $12,000/year</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted mb-2">Reward Points</label>
                            <h4 class="mb-0 text-primary">{{ $totalPoints ?? 0 }} pts</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-4">
                            <label class="form-label text-muted mb-2">Member Since</label>
                            <p class="mb-0">{{ $member->created_at->format('F j, Y') }}</p>
                        </div>
                        @if($member->membership_expires_at)
                            <div class="mb-4">
                                <label class="form-label text-muted mb-2">Valid Till</label>
                                <p class="mb-0">{{ $member->membership_expires_at->format('F j, Y') }}</p>
                            </div>
                            @endif
                        </div>
                        @if ($member->membershipTier)
                            <div>
                                <label class="form-label text-muted mb-2">Tier Benefits</label>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($member->membershipTier->benefits as $benefit)
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            {{ $benefit->title }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4">
                            <label class="form-label text-muted mb-2">About Company</label>
                            @if($member->company_description)
                                <div class="company-description">
                                    {!! $member->company_description !!}
                                </div>
                            @else
                                <p class="text-muted mb-0">Nothing about company</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <div class="position-fixed bottom-0 end-0 p-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle shadow-sm" style="width: 50px; height: 50px; padding: 9px;">
                <i class="bi bi-arrow-left" style="font-size: 20px;"></i>
            </a>
        </div>
    </div>

@endsection
