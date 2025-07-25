@extends('layouts.dashboard')
@section('title', 'Add Member')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Member</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('members.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="designation" class="form-label">Designation*</label>
                        <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                               id="designation" name="designation" value="{{ old('designation') }}" >
                        @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="whatsapp_phone" class="form-label">WhatsApp/Phone*</label>
                        <input type="tel" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror" 
                               id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone') }}">
                        @error('whatsapp_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_name" class="form-label">Company Name*</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                               id="company_name" name="company_name" value="{{ old('company_name') }}" >
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_telephone" class="form-label">Company Telephone*</label>
                        <input type="tel" class="form-control iti__tel-input @error('company_telephone') is-invalid @enderror" 
                               id="company_telephone" name="company_telephone" value="{{ old('company_telephone') }}">
                        @error('company_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="company_address" class="form-label">Company Address*</label>
                        <input type="text" class="form-control @error('company_address') is-invalid @enderror" 
                               id="company_address" name="company_address" value="{{ old('company_address') }}" >
                        @error('company_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="country_id" class="form-label">Country*</label>
                        <select class="form-select @error('country_id') is-invalid @enderror" 
                                id="country" name="country_id" data-old="{{ old('country_id') }}">
                            <option value="">Select Country</option>
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="city_id" class="form-label">City*</label>
                        <select class="form-select @error('city_id') is-invalid @enderror" 
                                id="city" name="city_id" data-old="{{ old('city_id') }}">
                            <option value="">Select City</option>
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="region_id" class="form-label">Region*</label>
                        <select class="form-select @error('region_id') is-invalid @enderror" 
                                id="region" name="region_id" data-old="{{ old('region_id') }}">
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
                                   placeholder="Select Date" value="{{ old('incorporation_date') }}">
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
                               id="tax_id" name="tax_id" value="{{ old('tax_id') }}" >
                        @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="website_linkedin" class="form-label">Website / LinkedIn*</label>
                        <input type="text" class="form-control @error('website_linkedin') is-invalid @enderror" 
                               id="website_linkedin" name="website_linkedin" value="{{ old('website_linkedin') }}" >
                        @error('website_linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="referred_by" class="form-label">Referred by</label>
                        <input type="text" class="form-control @error('referred_by') is-invalid @enderror" 
                               id="referred_by" name="referred_by" value="{{ old('referred_by') }}">
                        @error('referred_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Specializations*</label>
                        <div class="d-flex gap-3 bg-light p-2 rounded align-items-center px-3 flex-wrap @error('specializations') is-invalid @enderror">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Air" id="checkAir">
                                <label class="form-check-label" for="checkAir">Air</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Sea" id="checkSea">
                                <label class="form-check-label" for="checkSea">Sea</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Land" id="Land">
                                <label class="form-check-label" for="Land">Land</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Multimodal" id="Multimodal">
                                <label class="form-check-label" for="Multimodal">Multimodal</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Project Cargo" id="Cargo">
                                <label class="form-check-label" for="Cargo">Project Cargo</label>
                            </div>
                        </div>
                        @error('specializations')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Are you currently a member of any other network?*</label>
                        <div class="d-flex gap-3 bg-light p-2 rounded align-items-center px-3 flex-wrap @error('is_network_member') is-invalid @enderror">
                            <div class="form-check mb-0">
                                <input class="form-check-input" name="is_network_member" type="radio" value="yes" id="currentlyYes">
                                <label class="form-check-label" for="currentlyYes">Yes</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" name="is_network_member" type="radio" value="no" id="currentlyNo" checked>
                                <label class="form-check-label" for="currentlyNo">No</label>
                            </div>
                        </div>
                        @error('is_network_member')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12" id="networkField" style="display: none;">
                        <label for="network_name" class="form-label">Network Name*</label>
                        <input type="text" class="form-control @error('network_name') is-invalid @enderror" 
                               id="network_name" name="network_name" value="{{ old('network_name') }}">
                        @error('network_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="membership_tier" class="form-label">Membership Tier*</label>
                        <select class="form-select @error('membership_tier') is-invalid @enderror" 
                                id="membership_tier" name="membership_tier" >
                            <option value="">Select a membership tier</option>
                            @foreach($membershipTiers as $tier)
                                <option value="{{ $tier->id }}" {{ old('membership_tier') == $tier->id ? 'selected' : '' }}>
                                    {{ $tier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('membership_tier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="{{ asset('css/memberAdd.css') }}?v={{ rand(1, 1000000) }}">
<script src="{{asset('js/memberAdd.js')}}?v={{ rand(1, 1000000)"></script>
@endsection 