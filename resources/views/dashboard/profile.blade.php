@extends('layouts.dashboard')

@section('title', 'Profile')

@section('styles')
   <link rel="stylesheet" href="{{asset('css/memberProfile.css')}}?v={{ rand(1, 1000000) }}">
@endsection

@section('content')
    @if(auth()->user()->role === \App\Models\User::MEMBER)
        <div class="container-fluid">
            <div class="row">
                <!-- Member Profile Header -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        @if(auth()->user()->profile_photo)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Profile Photo" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                                  @else
                                    <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                                  @endif
                                    </div>
                                    <div>
                                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                        <p class="text-muted mb-0">{{ auth()->user()->designation }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        @if(auth()->user()->company_logo)
                                    <img src="{{ Storage::url(auth()->user()->company_logo) }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                                  @else
                                    <img src="" alt="Company Logo" class="rounded-circle" width="100" height="100" id="CompanyLogoPreview">
                                  @endif
                                    </div>
                                    <div>
                                        <h4 class="mb-1">{{ auth()->user()->company_name }}</h4>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('editmemberprofile',auth()->user()->id) }}" class="btn btn-outline-secondary">Edit Profile</a>
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
                                            <span class="info-value">{{ auth()->user()->email }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">WhatsApp/Phone</span>
                                            <span class="info-value">{{ auth()->user()->whatsapp_phone }}</span>
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
                                            <span class="info-value">{{ auth()->user()->company_name }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Company Telephone</span>
                                            <span class="info-value">{{ auth()->user()->company_telephone }}</span>
                                        </div>
                                        <div class="info-item ">
                                            <span class="info-label">Company Address</span>
                                            <span class="info-value">{{ auth()->user()->company_address }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Country</span>
                                            <span class="info-value">{{ auth()->user()->country->name ?? '-' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">City</span>
                                            <span class="info-value">{{ auth()->user()->city->name ?? '-' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Region</span>
                                            <span class="info-value">{{ auth()->user()->region->name ?? '-' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Tax ID</span>
                                            <span class="info-value">{{ auth()->user()->tax_id }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Incorporation Date</span>
                                            <span class="info-value">{{ auth()->user()->incorporation_date ? date('F j, Y', strtotime(auth()->user()->incorporation_date)) : '-' }}</span>
                                        </div>
                                        <div class="info-item full-width">
                                            <span class="info-label">Website / LinkedIn</span>
                                            <span class="info-value">
                                                <a href="{{ auth()->user()->website_linkedin }}" target="_blank" class="text-primary">
                                                    {{ auth()->user()->website_linkedin }}
                                                </a>
                                            </span>
                                        </div>
                                        <div class="info-item full-width">
                                            <span class="info-label">Specializations</span>
                                            <span class="info-value">
                                                <div class="d-flex flex-wrap gap-2">
                                                    @php
                                                        $specializations = is_string(auth()->user()->specializations)
                                                            ? json_decode(auth()->user()->specializations)
                                                            : auth()->user()->specializations;
                                                    @endphp
                                                    @foreach ($specializations ?? [] as $specialization)
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
                                                {{ ucfirst(auth()->user()->is_network_member) }}
                                                @if (auth()->user()->is_network_member === 'yes')
                                                    - {{ auth()->user()->network_name }}
                                                @endif
                                            </span>
                                        </div>
                                        @if (auth()->user()->referred_by)
                                            <div class="info-item full-width">
                                                <span class="info-label">Referred By</span>
                                                <span class="info-value">{{ auth()->user()->referred_by }}</span>
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
                                            {{ optional(auth()->user()->membershipTier)->name ?? 'No Tier' }}</h4>
                                    </div>
                                </div>
                                @if(auth()->user()->membership_expires_at)
                                <div class="mb-4">
                                    <label class="form-label text-muted mb-2">Valid Till</label>
                                    <p class="mb-0">{{ auth()->user()->membership_expires_at->format('F j, Y') }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted mb-2">Member Since</label>
                                <p class="mb-0">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                            </div>

                            @if (auth()->user()->membershipTier)
                                <div>
                                    <label class="form-label text-muted mb-2">Tier Benefits</label>
                                    <ul class="list-unstyled mb-0">
                                        @foreach (auth()->user()->membershipTier->benefits as $benefit)
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
            <!-- Back Button -->
            <div class="position-fixed bottom-0 end-0 p-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle shadow-sm" style="width: 50px; height: 50px; padding: 9px;">
                    <i class="bi bi-arrow-left" style="font-size: 20px;"></i>
                </a>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Profile</h5>
                            <a href="{{ route('editprofile',auth()->user()->id) }}" class="btn btn-primary btn-sm">Edit Profile</a>
                        </div>
                        <div class="col-xl-12 text-center mb-4">
                            @if(auth()->user()->profile_photo)
                            <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Profile Photo" class="img-fluid" style="max-height: 100px;">
                          @else
                            <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="img-fluid" style="max-height: 100px;">
                          @endif
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection