@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <script>
        window.defaults = @json($defaults);
    </script>
    <body style="overflow: hidden;">
        <div class="wrapper userlogin p-0 bg-black">
            <main class="content">
                <div class="row justify-content-center mx-0 bg-white overflow-hidden">
                    <div class="col-12 col-md-4 left-img vh-100 d-flex justify-content-center p-4"
                        style="background: url(./images/admin-login.webp) no-repeat center / cover">
                        <div class="left-side">
                            <a href="/"><img class="mb-3" src="{{ asset('images/logo.svg') }}" alt="Logo"
                                    width="auto" height="78"></a>
                        </div>
                    </div>
                    <div class="col-md-8 col-12 bg-black">
                        <div class="custom-card m-0 p-md-4">
                            <form role="form" method="POST" action="{{ route('register.post') }}">
                                @csrf
                                <div class="row setup-content mx-0" id="step-1">
                                    <div class="col-md-12 px-0">
                                        <h3 class="text-white text-center mb-3">Become a Member</h3>
                                        <div class="progress-bar-container mb-4">
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" role="progressbar" style="width: 50%;"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <span class="progress-step active">1</span>
                                                <span class="progress-step">2</span>
                                            </div>
                                        </div>
                                       
                                        <!-- Step 1 Content -->
                                        <div class="inputs-container row bg-dark rounded mt-3">
                                            <!-- ... All existing form fields from step 1 ... -->
                                            <div class="row p-3 pb-0 mx-0">
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Name*</label>
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name*" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Designation*</label>
                                                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" placeholder="Designation*" value="{{ old('designation') }}">
                                                    @error('designation')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Email*</label>
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email*" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">WhatsApp/Phone*</label>
                                                    <input type="tel" name="whatsapp_phone" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror"
                                                         value="{{ old('whatsapp_phone') }}">
                                                    @error('whatsapp_phone')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Company Name*</label>
                                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name*" value="{{ old('company_name') }}">
                                                    @error('company_name')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Company Telephone*</label>
                                                    <input type="tel" name="company_telephone" class="form-control iti__tel-input @error('company_telephone') is-invalid @enderror"
                                                         value="{{ old('company_telephone') }}">
                                                    @error('company_telephone')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Company Address*</label>
                                                    <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" placeholder="Company Address*" value="{{ old('company_address') }}">
                                                    @error('company_address')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Country*</label>
                                                    <select class="form-select @error('country_id') is-invalid @enderror" id="country" name="country_id" data-old="{{ old('country_id') }}">
                                                        <option value="">Select Country</option>
                                                    </select>
                                                    @error('country_id')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">City*</label>
                                                    <select class="form-select @error('city_id') is-invalid @enderror" id="city" name="city_id" data-old="{{ old('city_id') }}">
                                                        <option value="">Select City</option>
                                                    </select>
                                                    @error('city_id')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Region*</label>
                                                    <select class="form-select @error('region_id') is-invalid @enderror" id="region" name="region_id" data-old="{{ old('region_id') }}">
                                                        <option value="">Select Region</option>
                                                    </select>
                                                    @error('region_id')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Incorporation Date*</label>
                                                    <div class="date-picker-wrapper">
                                                        <input type="text" class="form-control @error('incorporation_date') is-invalid @enderror"
                                                            id="incorporation_date" name="incorporation_date"
                                                            placeholder="Select Date"  value="{{ old('incorporation_date') }}" >
                                                        <svg class="calendar-icon" width="16" height="16"
                                                            fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                    </div>
                                                    @error('incorporation_date')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Tax ID*</label>
                                                    <input type="text" name="tax_id" class="form-control @error('tax_id') is-invalid @enderror" placeholder="Tax ID*" value="{{ old('tax_id') }}">
                                                    @error('tax_id')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Website / LinkedIn*</label>
                                                    <input type="text" name="website_linkedin" class="form-control @error('website_linkedin') is-invalid @enderror"
                                                        placeholder="Website / LinkedIn*" value="{{ old('website_linkedin') }}">
                                                    @error('website_linkedin')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-6">
                                                    <label class="form-label text-white">Referred by</label>
                                                    <input type="text" name="referred_by" class="form-control @error('referred_by') is-invalid @enderror" placeholder="Referred by" value="{{ old('referred_by') }}">
                                                    @error('referred_by')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12">
                                                    <label class="form-label text-white">Specializations*</label>
                                                    <div class="d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap @error('specializations') is-invalid @enderror">
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" name="specializations[]" value="Air"
                                                                id="checkAir" {{ is_array(old('specializations')) && in_array('Air', old('specializations')) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="checkAir">Air</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" name="specializations[]"
                                                                value="Sea" id="checkSea" {{ is_array(old('specializations')) && in_array('Sea', old('specializations')) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="checkSea">Sea</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" name="specializations[]"
                                                                value="Land" id="Land" {{ is_array(old('specializations')) && in_array('Land', old('specializations')) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="Land">Land</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" name="specializations[]"
                                                                value="Multimodal" id="Multimodal" {{ is_array(old('specializations')) && in_array('Multimodal', old('specializations')) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="Multimodal">Multimodal</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" name="specializations[]"
                                                                value="Project Cargo" id="Cargo" {{ is_array(old('specializations')) && in_array('Project Cargo', old('specializations')) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="Cargo">Project Cargo</label>
                                                        </div>
                                                    </div>
                                                    @error('specializations')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                               
                                                

                                                <div class="mb-3 col-12">
                                                    <label class="form-label text-white">Are you currently a member of any other network?*</label>
                                                    <div class="d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap @error('is_network_member') is-invalid @enderror">
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" name="is_network_member"
                                                                type="radio" value="yes" id="currentlyYes" {{ old('is_network_member') == 'yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="currentlyYes">Yes</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" name="is_network_member"
                                                                type="radio" value="no" id="currentlyNo" {{ old('is_network_member', 'no') == 'no' ? 'checked' : '' }}>
                                                            <label class="form-check-label text-white" for="currentlyNo">No</label>
                                                        </div>
                                                    </div>
                                                    @error('is_network_member')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-12 col-md-12" id="networkField" style="display: none;">
                                                    <label class="form-label text-white">Network Name*</label>
                                                    <input type="text" name="network_name" class="form-control @error('network_name') is-invalid @enderror"
                                                        placeholder="Network Name*" value="{{ old('network_name') }}">
                                                    @error('network_name')
                                                        <div class="invalid-feedback d-block text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <button class="btn btn-primary nextBtn px-5" type="button">Next Step</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 Content -->
                                <div class="row setup-content" id="step-2" style="display: none;">
                                    <div class="col-md-12 px-0">
                                        <h3 class="text-white text-center mb-3">Choose Your Plan</h3>
                                        <div class="progress-bar-container progress_barmain mb-4">
                                            <div class="progress" style="height: 3px; margin-inline: 50px;">
                                                <div class="progress-bar" role="progressbar" style="width: 100%;"
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <span class="progress-step">1</span>
                                                <span class="progress-step active">2</span>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            @foreach($membershipTiers as $tier)
                                            <div class="col-12 col-md-4">
                                                <div class="Benefit_cards h-100">
                                                    <input class="form-check-input" name="membership_tier" type="radio"
                                                        value="{{ $tier->id }}" id="Benefit{{ $tier->id }}" 
                                                        {{ old('membership_tier', '1') == $tier->id ? 'checked' : '' }}>
                                                    <label class="h-100" for="Benefit{{ $tier->id }}">
                                                        <div class="bg-dark p-3 rounded h-100">
                                                            <h4 class="text-white pb-2">{{ $tier->name }} Benefits</h4>
                                                            <ul class="list-group">
                                                                @foreach($tier->benefits as $benefit)
                                                                    <li class="text-white mb-2">{{ $benefit->title }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 mb-3 w-100">
                                            <div class="form-check">
                                                <input class="form-check-input @error('consent') is-invalid @enderror" type="checkbox" id="consentCheckbox"
                                                    name="consent"  {{ old('consent') ? 'checked' : '' }}>
                                                <label class="form-check-label text-white" for="consentCheckbox">
                                                    I consent to FR8NITY collecting, storing, and using my personal data to
                                                    process my membership application, provide access to platform features,
                                                    and contact me with relevant updates. I understand that my information
                                                    will be handled in accordance with applicable data protection laws,
                                                    including the PDPA and GDPR.<br>
                                                    <span class="d-block mt-2">
                                                        Note : You can read our full Privacy Policy to understand how we
                                                        protect your data and your rights.
                                                    </span>
                                                </label>
                                            </div>
                                            @error('consent')
                                                <div class="invalid-feedback d-block text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-center mt-4 pt-4 gap-3">
                                            <button class="btn btn-secondary px-4 rounded_30 backBtn" type="button">Back</button>
                                            <button class="btn btn-primary pull-right px-4" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
<script src="{{asset('js/register.js?v=' . rand(1, 1000000))}}"></script>
@endsection