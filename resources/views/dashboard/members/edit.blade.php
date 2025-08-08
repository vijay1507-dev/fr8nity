@extends('layouts.dashboard')
@section('title', 'Edit Member')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">@if(auth()->user()->role == \App\Models\User::MEMBER) Edit Profile @else Edit Member @endif</h4>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="card-body">

            @if(auth()->user()->role == \App\Models\User::MEMBER)
            <form action="{{ route('members.updateprofile', $member) }}" method="POST" enctype="multipart/form-data">
            @else
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf
                @method('PATCH')
                @if(auth()->user()->role == \App\Models\User::MEMBER)
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
                            <div class="form-text">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</div>
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
                            <div class="form-text">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</div>
                            @error('company_logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                </div>
                @endif

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
@endsection 