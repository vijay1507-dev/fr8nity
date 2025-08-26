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
                                    <img src="{{ Storage::url(auth()->user()->company_logo) }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="CompanyLogoPreview">
                                  @else
                                    <img src="{{ asset('images/default_company.png') }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="CompanyLogoPreview">
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
                            <p class="mb-0 fs-5">Member Information</p>
                        </div>
                        <div class="card-body p-0">
                            <!-- Contact Information -->
                            <div class="info-section">
                                <div class="info-header">
                                    <p class="text-uppercase mb-0 fs-6"><i class="bi bi-person me-2"></i>Contact Information</p>
                                </div>
                                <div class="info-body">ss
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
                                    <p class="text-uppercase mb-0 fs-6"><i class="bi bi-building me-2"></i>Company Information</p>
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
                                    <p class="text-uppercase mb-0 fs-6"><i class="bi bi-globe me-2"></i>Network Information</p>
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
                                                <span class="info-value">{{ auth()->user()->referredBy->name ?? 'N/A' }}</span>
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
                            <p class="mb-0 fs-5">Membership Details</p>
                        </div>
                        <div class="card-body">
                            <div class="d-flex row">
                                <div class="col-6 mb-4">
                                    <span class="info-label d-block">Current Tier</span>
                                    <div class="d-flex align-items-center">
                                        <span class="info-value">
                                            {{ optional(auth()->user()->membershipTier)->name ?? 'No Tier' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <span class="info-label d-block">CREDIT Protection</span>
                                  <span class="info-value">{{ optional(auth()->user()->membershipTier)->credit_protection ?? 'No credit protection available' }}</span>
                                </div>
                                
                            </div>
                            <div class="d-flex row ">
                                <div class="col-6 mb-4">
                                   <span class="info-label d-block ">Reward Points</span>
                                   <span class="info-value text-primary">{{ $totalPoints ?? 0 }} pts</span>
                                </div>
                                @if(auth()->user()->membership_number)
                                    <div class= " col-6 mb-4">
                                      <span class="info-label d-block">Membership No.</span>
                                          <span class="info-value">{{ auth()->user()->membership_number }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex row">
                            <div class="col-6 mb-4">
                               <span class="info-label d-block">Member Since</span>
                               <span class="info-value">{{ auth()->user()->created_at->format('F j, Y') }}</span>
                            </div>
                            @if(auth()->user()->membership_expires_at)
                                <div class=" col-6 mb-4">
                                   <span class="info-label d-block">Valid Till</span>
                                   <span class="info-value">{{ auth()->user()->membership_expires_at->format('F j, Y') }}</span>
                                </div>
                                @endif
                            </div>
                            @if (auth()->user()->membershipTier)
                                <div>
                                   <span class="info-label">Tier Benefits</span>
                                    <ul class="list-unstyled mb-0">
                                        @foreach (auth()->user()->membershipTier->benefits as $benefit)
                                            <li class="mb-2 d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                {{ $benefit->title }}
                                            </li>
                                        @endforeach
					@if(auth()->user()->membershipTier->benefits->isEmpty())
                                            <li class="text-muted">No benefits available for this tier.</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        
                         
                        </div>
                    </div>
                     <div class="col-12">
                           <div class="mt-4 card bg-white p-3">
                               <span class="info-label">About Company</span>
                                @if(auth()->user()->company_description)
                                    <div class="company-description">
                                        {!! auth()->user()->company_description !!}
                                    </div>
                                @else
                                 <span class="info-value">Nothing about company</span>
                                @endif
                            </div>
                     </div>

                       <div class="col-12">
                           @if(auth()->user()->certificate_document)
                            <div class="mt-4 card bg-white p-3">
                                <span class="info-label">E-certificate</span>
                                <div class="e-certificate-section">
                                   
                                        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                            <!-- Certificate Image Display - Clickable for Preview -->
                                            <div class="certificate-preview mb-3" style="border-radius: 10px; padding: 10px; background: rgba(255, 255, 255, 0.1); cursor: pointer;">
                                                <a href="{{ Storage::url(auth()->user()->certificate_document) }}" 
                                                   target="_blank"
                                                   style="text-decoration: none; display: block;">
                                                    <img src="{{ Storage::url(auth()->user()->certificate_document) }}" 
                                                         alt="E-Certificate - Click to Preview" 
                                                         class="img-fluid rounded"
                                                         style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px; transition: all 0.3s ease;"
                                                         onmouseover="this.style.transform='scale(1.05)'"
                                                         onmouseout="this.style.transform='scale(1)'">
                                                </a>
                                            </div>
                                            
                                            @if(auth()->user()->certificate_uploaded_at)
                                            <small class="text-muted mt-1">
                                                Last updated: {{ auth()->user()->certificate_uploaded_at->format('M d, Y') }}
                                            </small>
                                            @endif
                                        </div>
                                 
                                </div>
                            </div>
                            @endif
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