@extends('layouts.dashboard')
@section('title', 'Edit Member')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">@if(auth()->user()->role == \App\Models\User::MEMBER) Edit Profile @else Edit Member @endif</h4>
            <div class="d-flex gap-2 align-items-center">
                @if(auth()->user()->role !== \App\Models\User::MEMBER)
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
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">

            @if(auth()->user()->role == \App\Models\User::MEMBER)
            <form action="{{ route('members.updateprofile', $member) }}" method="POST" enctype="multipart/form-data">
            @else
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf
                @method('PATCH')
                {{-- @if(auth()->user()->role == \App\Models\User::MEMBER) --}}
                <div class="row">
                <div class="col-6 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            @if($member->profile_photo)
                                <img src="{{ Storage::url($member->profile_photo) }}" alt="Profile Photo" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                            @else
                                <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                            @endif
                        </div>
                        <div>
                            <label class="form-label" for="profile_photo">Profile Photo</label>
                            <input type="file" id="profile_photo" name="profile_photo" class="form-control" accept="image/*">
                            <div class="form-text">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF</div>
                            @error('profile_photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                           
                            @if($member->company_logo)
                                <img src="{{ Storage::url($member->company_logo) }}" alt="Profile Photo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                            @else
                                <img src="{{ asset('images/default_company.png') }}" alt="Company Logo" class="rounded-circle" width="100" height="100" id="companyLogoPreview">
                            @endif
                        </div>
                        <div>
                            <label class="form-label" for="company_logo">Company Logo</label>
                            <input type="file" id="company_logo" name="company_logo" class="form-control" accept="image/*">
                            <div class="form-text">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF</div>
                            @error('company_logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                </div>
                {{-- @endif --}}

                @if(auth()->user()->role == \App\Models\User::MEMBER)
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    You can update your profile picture, company logo, about company description, and password. For any other changes, please contact our support team.
                </div>
                @endif

               

                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $member->name) }}" 
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="designation" class="form-label">Designation*</label>
                        <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                               id="designation" name="designation" value="{{ old('designation', $member->designation) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $member->email) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        <div class="form-text">Email cannot be changed as it is used for login.</div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="whatsapp_phone" class="form-label">WhatsApp/Phone*</label>
                        <input type="tel" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror" 
                               id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone', $member->whatsapp_phone) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('whatsapp_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_name" class="form-label">Company Name*</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                               id="company_name" name="company_name" value="{{ old('company_name', $member->company_name) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_telephone" class="form-label">Company Telephone*</label>
                        <input type="tel" class="form-control iti__tel-input @error('company_telephone') is-invalid @enderror" 
                               id="company_telephone" name="company_telephone" value="{{ old('company_telephone', $member->company_telephone) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('company_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_address" class="form-label">Company Address*</label>
                        <input type="text" class="form-control @error('company_address') is-invalid @enderror" 
                               id="company_address" name="company_address" value="{{ old('company_address', $member->company_address) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('company_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="country_id" class="form-label">Country*</label>
                        <select class="form-select @error('country_id') is-invalid @enderror" 
                                id="country" name="country_id" data-old="{{ old('country_id', $member->country_id) }}"
                                {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                            <option value="">Select Country</option>
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="city_id" class="form-label">City*</label>
                        <select class="form-select @error('city_id') is-invalid @enderror" 
                                id="city" name="city_id" data-old="{{ old('city_id', $member->city_id) }}"
                                {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                            <option value="">Select City</option>
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="mb-3 col-12 col-md-6">
                        <label for="region_id" class="form-label">Region*</label>
                        <select class="form-select @error('region_id') is-invalid @enderror" 
                                id="region" name="region_id" data-old="{{ old('region_id', $member->region_id) }}"
                                {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                            <option value="">Select Region</option>
                        </select>
                        @error('region_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="incorporation_date" class="form-label">Incorporation Date*</label>
                        <div class="date-picker-wrapper">
                            <input type="text" class="form-control @error('incorporation_date') is-invalid @enderror" 
                                   id="incorporation_date" name="incorporation_date" 
                                   placeholder="Select Date" value="{{ old('incorporation_date', $member->incorporation_date) }}"
                                   {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                            <svg class="calendar-icon" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        @error('incorporation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="tax_id" class="form-label">Tax ID*</label>
                        <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
                               id="tax_id" name="tax_id" value="{{ old('tax_id', $member->tax_id) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="website_linkedin" class="form-label">Website / LinkedIn*</label>
                        <input type="text" class="form-control @error('website_linkedin') is-invalid @enderror" 
                               id="website_linkedin" name="website_linkedin" value="{{ old('website_linkedin', $member->website_linkedin) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('website_linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="referred_by" class="form-label">Referred by</label>
                        <input type="text" class="form-control @error('referred_by') is-invalid @enderror" 
                               id="referred_by" name="referred_by" value="{{ old('referred_by', $member->referredBy->name ?? '') }}" {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('referred_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Specializations*</label>
                        @php
                            $specializations = is_string($member->specializations) ? json_decode($member->specializations) : $member->specializations;
                        @endphp
                        <div class="d-flex gap-3 bg-light p-2 rounded align-items-center px-3 flex-wrap @error('specializations') is-invalid @enderror">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Air" id="checkAir"
                                    {{ in_array('Air', $specializations) ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="checkAir">Air</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Sea" id="checkSea"
                                    {{ in_array('Sea', $specializations) ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="checkSea">Sea</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Land" id="Land"
                                    {{ in_array('Land', $specializations) ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="Land">Land</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Multimodal" id="Multimodal"
                                    {{ in_array('Multimodal', $specializations) ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="Multimodal">Multimodal</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Project Cargo" id="Cargo"
                                    {{ in_array('Project Cargo', $specializations) ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="Cargo">Project Cargo</label>
                            </div>
                        </div>
                        @error('specializations')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label for="company_description" class="form-label">About Company*</label>
                        <textarea class="form-control @error('company_description') is-invalid @enderror" 
                                  id="company_description" name="company_description" rows="8" 
                                  placeholder="Write about your company, services, experience, and what makes your company unique...">{{ old('company_description', $member->company_description) }}</textarea>
                        <div class="form-text">This description will be displayed on your member profile page and in the member directory. You can use the toolbar above to format your text.</div>
                        @error('company_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Are you currently a member of any other network?*</label>
                        <div class="d-flex gap-3 bg-light p-2 rounded align-items-center px-3 flex-wrap @error('is_network_member') is-invalid @enderror">
                            <div class="form-check mb-0">
                                <input class="form-check-input" name="is_network_member" type="radio" value="yes" id="currentlyYes"
                                    {{ $member->is_network_member === 'yes' ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="currentlyYes">Yes</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" name="is_network_member" type="radio" value="no" id="currentlyNo"
                                    {{ $member->is_network_member === 'no' ? 'checked' : '' }}
                                    {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                                <label class="form-check-label" for="currentlyNo">No</label>
                            </div>
                        </div>
                        @error('is_network_member')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12" id="networkField" style="{{ $member->is_network_member === 'yes' ? 'display: block;' : 'display: none;' }}">
                        <label for="network_name" class="form-label">Network Name*</label>
                        <input type="text" class="form-control @error('network_name') is-invalid @enderror" 
                               id="network_name" name="network_name" value="{{ old('network_name', $member->network_name) }}"
                               {{ auth()->user()->role == \App\Models\User::MEMBER ? 'readonly' : '' }}>
                        @error('network_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 col-12 col-md-6">
                        <label for="membership_tier" class="form-label">Membership Tier*</label>
                        <select class="form-select @error('membership_tier') is-invalid @enderror" 
                                id="membership_tier" name="membership_tier"
                                {{ auth()->user()->role == \App\Models\User::MEMBER ? 'disabled' : '' }}>
                            <option value="">Select a membership tier</option>
                            @foreach($membershipTiers as $tier)
                                <option value="{{ $tier->id }}" {{ old('membership_tier', $member->membership_tier) == $tier->id ? 'selected' : '' }}>
                                    {{ $tier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('membership_tier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if(auth()->user()->role === App\Models\User::SUPER_ADMIN)
                <!-- Certificate Section -->
                <div class="card mt-4 mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Member E-Certificate</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if($member->certificate_document)
                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1"><strong>Current E-Certificate:</strong></p>
                                                <p class="mb-0">Uploaded on {{ $member->certificate_uploaded_at->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <a href="{{ Storage::url($member->certificate_document) }}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="bi bi-file-earmark-text me-2"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="certificate_document" class="form-label">Upload E-Certificate</label>
                                    <input type="file" class="form-control @error('certificate_document') is-invalid @enderror" 
                                           id="certificate_document" name="certificate_document" 
                                           accept="jpg,.jpeg,.png">
                                    <div class="form-text">Supported formats: JPG, JPEG, PNG. Maximum file size: 5MB</div>
                                    @error('certificate_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Password Update Section -->
                <div class="card mt-4 mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Update Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(auth()->user()->role == \App\Models\User::MEMBER)
                            <div class="mb-3 col-12">
                                <label for="current_password" class="form-label">Current Password*</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" 
                                       autocomplete="new-password" 
                                       value="">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <div class="mb-3 col-12 col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       autocomplete="new-password" 
                                       value="">
                                <div class="form-text">Leave blank to keep current password</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-12 col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       autocomplete="new-password" 
                                       value="">
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
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" class="btn btn-primary">Update Member</button>
                </div>
            </form>
        </div>
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
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action will cancel the membership for <strong>{{ $member->name }}</strong>.
                    </div>
                    <p>Please provide a reason for cancellation:</p>
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label">Cancellation Reason*</label>
                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="4" required 
                                  placeholder="Please provide a detailed reason for cancelling this membership..."></textarea>
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

@endsection

@section('scripts')
<link rel="stylesheet" href="{{asset('css/memberAdd.css')}}?v={{ rand(1, 1000000) }}">
<script src="{{asset('js/memberAdd.js')}}?v={{ rand(1, 1000000) }}"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    // Pass auth user role to JavaScript
    const auth_user_role = "{{ auth()->user()->role }}";
    // Store the initial city name for member role
    @if(auth()->user()->role == \App\Models\User::MEMBER && $member->city)
        $('#city').data('old-name', "{{ $member->city->name }}");
    @endif
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
        renewButton.setAttribute('data-bs-target', '#earlyRenewalModal');
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

    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#company_description'), {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|', 'heading',
                        '|', 'bold', 'italic',
                        '|', 'link',
                        '|', 'bulletedList', 'numberedList',
                        '|', 'outdent', 'indent',
                        '|', 'removeFormat'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                },
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload'],
                placeholder: 'Write about your company, services, experience, and what makes your company unique...'
            })
            .then(editor => {
                // Auto-save content to textarea
                editor.model.document.on('change:data', () => {
                    const data = editor.getData();
                    document.querySelector('#company_description').value = data;
                });
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

@include('dashboard.members.partials.early-renewal-modal')
@endsection 