@extends('layouts.dashboard')
@section('title', 'Edit Trade Member')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Trade Member</h4>
            <a href="{{ route('trade-members.show', $tradeMember) }}" class="btn btn-secondary">Back to Details</a>
        </div>
        <div class="card-body">
            <form action="{{ route('trade-members.update', $tradeMember) }}" method="POST" id="editTradeMemberForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <h5 class="mb-4">Personal Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $tradeMember->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation', $tradeMember->designation) }}">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $tradeMember->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">WhatsApp/Phone</label>
                            <input type="tel" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror" name="whatsapp_phone" value="{{ old('whatsapp_phone', $tradeMember->whatsapp_phone) }}">
                            @error('whatsapp_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="col-md-6">
                        <h5 class="mb-4">Company Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $tradeMember->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product/Industry Category</label>
                            <input type="text" class="form-control @error('product_industry_category') is-invalid @enderror" name="product_industry_category" value="{{ old('product_industry_category', $tradeMember->product_industry_category) }}">
                            @error('product_industry_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shipping Frequency</label>
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded">
                                @php
                                    $frequencies = ['Daily', 'Weekly', 'Monthly', 'Ad-hoc'];
                                    $selectedFrequencies = old('shipping_frequency', ($tradeMember->shipping_frequency) ?? []);
                                @endphp
                                @foreach($frequencies as $frequency)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $frequency }}" name="shipping_frequency[]" value="{{ $frequency }}" {{ in_array($frequency, $selectedFrequencies) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $frequency }}">{{ $frequency }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('shipping_frequency')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mode of Shipment</label>
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded">
                                @php
                                    $modes = ['Air', 'Sea', 'Land'];
                                    $selectedModes = old('mode_of_shipment', ($tradeMember->mode_of_shipment) ?? []);
                                @endphp
                                @foreach($modes as $mode)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $mode }}" name="mode_of_shipment[]" value="{{ $mode }}" {{ in_array($mode, $selectedModes) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $mode }}">{{ $mode }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('mode_of_shipment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Shipment Information -->
                    <div class="col-md-6">
                        <h5 class="mb-4">Shipment Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Origin Country</label>
                            <select class="form-select @error('origin_country') is-invalid @enderror" name="origin_country" id="origin_country">
                                <option value="">Select Country</option>
                            </select>
                            @error('origin_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Destination Country</label>
                            <select class="form-select @error('destination_country') is-invalid @enderror" name="destination_country" id="destination_country">
                                <option value="">Select Country</option>
                            </select>
                            @error('destination_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estimated Shipment Volume</label>
                            <input type="text" class="form-control @error('estimated_shipment_volume') is-invalid @enderror" name="estimated_shipment_volume" value="{{ old('estimated_shipment_volume', $tradeMember->estimated_shipment_volume) }}">
                            @error('estimated_shipment_volume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <h5 class="mb-4">Additional Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Looking For</label>
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded">
                                @php
                                    $lookingFor = ['Speed', 'Cost', 'Trust', 'Visibility', 'Flexibility'];
                                    $selectedLookingFor = old('looking_for', ($tradeMember->looking_for) ?? []);
                                @endphp
                                @foreach($lookingFor as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item }}" name="looking_for[]" value="{{ $item }}" {{ in_array($item, $selectedLookingFor) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $item }}">{{ $item }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('looking_for')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Details</label>
                            <textarea class="form-control @error('additional_details') is-invalid @enderror" name="additional_details" rows="4">{{ old('additional_details', $tradeMember->additional_details) }}</textarea>
                            @error('additional_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('trade-members.show', $tradeMember) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Trade Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize international telephone input
    const phoneInput = document.querySelector('input[name="whatsapp_phone"]');
    const iti = window.intlTelInput(phoneInput, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        separateDialCode: true,
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            fetch("https://ipapi.co/json")
                .then(res => res.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("US"));
        }
    });

    // Initialize Select2 for country dropdowns
    const countryData = {
        origin: {
            oldValue: {{ old('origin_country', $tradeMember->origin_country ?? 'null') }},
            element: '#origin_country'
        },
        destination: {
            oldValue: {{ old('destination_country', $tradeMember->destination_country ?? 'null') }},
            element: '#destination_country'
        }
    };

    // Initialize each country dropdown
    Object.entries(countryData).forEach(([type, data]) => {
        $(data.element).select2({
            theme: 'default',
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%'
        });

        // Load countries
        $.get('/get-countries', function(countries) {
            const select = $(data.element);
            const oldCountryId = data.oldValue;
            
            countries.forEach(function(country) {
                let option = new Option(country.name, country.id, false, country.id == oldCountryId);
                select.append(option);
            });

            select.trigger('change');
        });
    });

    // Form validation
    $("#editTradeMemberForm").validate({
        ignore: [],
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        rules: {
            'name': {
                required: true,
                minlength: 2
            },
            'email': {
                required: true,
                email: true
            },
            'whatsapp_phone': {
                required: true
            },
            'company_name': {
                required: true
            },
            'product_industry_category': {
                required: true
            },
            'origin_country': {
                required: true
            },
            'destination_country': {
                required: true
            },
            'estimated_shipment_volume': {
                required: true
            }
        },
        submitHandler: function(form) {
            // Add phone number with country code
            if (phoneInput.value.trim()) {
                phoneInput.value = iti.getNumber();
            }
            form.submit();
        }
    });
});
</script>
@endsection 