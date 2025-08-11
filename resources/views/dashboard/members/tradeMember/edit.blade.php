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
                            <label class="form-label required">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $tradeMember->name) }}" required>
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
                            <label class="form-label required">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $tradeMember->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">WhatsApp/Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror" name="whatsapp_phone" value="{{ old('whatsapp_phone', $tradeMember->whatsapp_phone) }}" required>
                            @error('whatsapp_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="col-md-6">
                        <h5 class="mb-4">Company Information</h5>
                        <div class="mb-3">
                            <label class="form-label required">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $tradeMember->company_name) }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Product/Industry Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('product_industry_category') is-invalid @enderror" name="product_industry_category" value="{{ old('product_industry_category', $tradeMember->product_industry_category) }}" required>
                            @error('product_industry_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shipping Frequency</label>
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded @error('shipping_frequency') is-invalid @enderror">
                                @php
                                    $frequencies = ['Daily', 'Weekly', 'Monthly', 'Ad-hoc'];
                                    $selectedFrequencies = old('shipping_frequency', is_array($tradeMember->shipping_frequency) ? $tradeMember->shipping_frequency : json_decode($tradeMember->shipping_frequency ?? '[]', true));
                                    if (!is_array($selectedFrequencies)) {
                                        $selectedFrequencies = [];
                                    }
                                @endphp
                                @foreach($frequencies as $frequency)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="frequency_{{ $frequency }}" name="shipping_frequency[]" value="{{ $frequency }}" {{ in_array($frequency, $selectedFrequencies) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="frequency_{{ $frequency }}">{{ $frequency }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('shipping_frequency')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mode of Shipment</label>
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded @error('mode_of_shipment') is-invalid @enderror">
                                @php
                                    $modes = ['Air', 'Sea', 'Land'];
                                    $selectedModes = old('mode_of_shipment', is_array($tradeMember->mode_of_shipment) ? $tradeMember->mode_of_shipment : json_decode($tradeMember->mode_of_shipment ?? '[]', true));
                                    if (!is_array($selectedModes)) {
                                        $selectedModes = [];
                                    }
                                @endphp
                                @foreach($modes as $mode)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="mode_{{ $mode }}" name="mode_of_shipment[]" value="{{ $mode }}" {{ in_array($mode, $selectedModes) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mode_{{ $mode }}">{{ $mode }}</label>
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
                            <label class="form-label required">Origin Country <span class="text-danger">*</span></label>
                            <select class="form-select @error('origin_country') is-invalid @enderror" name="origin_country" id="origin_country" required>
                                <option value="">Select Country</option>
                            </select>
                            @error('origin_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Destination Country <span class="text-danger">*</span></label>
                            <select class="form-select @error('destination_country') is-invalid @enderror" name="destination_country" id="destination_country" required>
                                <option value="">Select Country</option>
                            </select>
                            @error('destination_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Estimated Shipment Volume <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('estimated_shipment_volume') is-invalid @enderror" name="estimated_shipment_volume" value="{{ old('estimated_shipment_volume', $tradeMember->estimated_shipment_volume) }}" required>
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
                            <div class="checkbox-group d-flex gap-3 bg-light p-2 rounded @error('looking_for') is-invalid @enderror">
                                @php
                                    $lookingFor = ['Speed', 'Cost', 'Trust', 'Visibility', 'Flexibility'];
                                    $selectedLookingFor = old('looking_for', is_array($tradeMember->looking_for) ? $tradeMember->looking_for : json_decode($tradeMember->looking_for ?? '[]', true));
                                    if (!is_array($selectedLookingFor)) {
                                        $selectedLookingFor = [];
                                    }
                                @endphp
                                @foreach($lookingFor as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="looking_{{ $item }}" name="looking_for[]" value="{{ $item }}" {{ in_array($item, $selectedLookingFor) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="looking_{{ $item }}">{{ $item }}</label>
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
                    <button type="submit" class="btn btn-primary">Update Trade Member</button>
                </div>
            </form>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize international telephone input
    const phoneInput = document.querySelector('input[name="whatsapp_phone"]');
    const iti = window.intlTelInput(phoneInput, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        separateDialCode: true,
        initialCountry: "auto",
        preferredCountries: ['us', 'gb', 'ae', 'sg'],
        nationalMode: false,
        formatOnDisplay: true,
        geoIpLookup: function(callback) {
            fetch("https://ipapi.co/json")
                .then(res => res.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("sg"));
        }
    });

    // Initialize Select2 for country dropdowns
    const countryData = {
        origin: {
            oldValue: "{{ old('origin_country', $tradeMember->origin_country ?? '') }}",
            element: '#origin_country'
        },
        destination: {
            oldValue: "{{ old('destination_country', $tradeMember->destination_country ?? '') }}",
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
        }).fail(function() {
            console.error('Failed to load countries for ' + type);
        });
    });

    // Custom validation method for checkboxes
    $.validator.addMethod("checkboxRequired", function(value, element) {
        return $('input[name="' + element.name + '"]:checked').length > 0;
    }, "Please select at least one option.");

    // Custom validation method for Intel Tel Input
    $.validator.addMethod("validPhone", function(value, element) {
        if (!value.trim()) return false;
        return iti.isValidNumber();
    }, "Please enter a valid phone number");

    // Phone number input event handler
    phoneInput.addEventListener('blur', function() {
        $(phoneInput).valid(); // Trigger validation
    });

    phoneInput.addEventListener('countrychange', function() {
        $(phoneInput).valid(); // Revalidate when country changes
    });

    // Form validation
    $("#editTradeMemberForm").validate({
        ignore: [],
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertAfter(element.closest('.checkbox-group'));
            } else if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid');
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            }
        },
        rules: {
            'name': {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'email': {
                required: true,
                email: true,
                maxlength: 255
            },
            'whatsapp_phone': {
                required: true,
                validPhone: true
            },
            'company_name': {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'product_industry_category': {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'origin_country': {
                required: true
            },
            'destination_country': {
                required: true
            },
            'estimated_shipment_volume': {
                required: true,
                maxlength: 255
            },
            'designation': {
                maxlength: 255
            },
            'additional_details': {
                maxlength: 1000
            }
        },
        messages: {
            'name': {
                required: "Name is required",
                minlength: "Name must be at least 2 characters long",
                maxlength: "Name cannot exceed 255 characters"
            },
            'email': {
                required: "Email is required",
                email: "Please enter a valid email address",
                maxlength: "Email cannot exceed 255 characters"
            },
            'whatsapp_phone': {
                required: "WhatsApp/Phone is required",
                minlength: "Phone number must be at least 10 digits"
            },
            'company_name': {
                required: "Company name is required",
                minlength: "Company name must be at least 2 characters long",
                maxlength: "Company name cannot exceed 255 characters"
            },
            'product_industry_category': {
                required: "Product/Industry category is required",
                minlength: "Category must be at least 2 characters long",
                maxlength: "Category cannot exceed 255 characters"
            },
            'origin_country': {
                required: "Origin country is required"
            },
            'destination_country': {
                required: "Destination country is required"
            },
            'estimated_shipment_volume': {
                required: "Estimated shipment volume is required",
                maxlength: "Volume cannot exceed 255 characters"
            }
        },
        submitHandler: function(form) {
            // Validate phone number one more time before submit
            if (!iti.isValidNumber()) {
                $(phoneInput).addClass('is-invalid').focus();
                return false;
            }
            
            // Show loading state immediately
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Updating...');
            
            // Create a hidden input with the international number instead of changing the visible input
            const internationalNumber = iti.getNumber();
            let hiddenPhoneInput = $('#hidden_whatsapp_phone');
            
            if (hiddenPhoneInput.length === 0) {
                hiddenPhoneInput = $('<input type="hidden" id="hidden_whatsapp_phone" name="whatsapp_phone">');
                $(form).append(hiddenPhoneInput);
            }
            
            // Set the international number in hidden input
            hiddenPhoneInput.val(internationalNumber);
            
            // Remove name attribute from visible input to prevent it from being submitted
            $(phoneInput).removeAttr('name');
            
            // Reset loading state after timeout (fallback)
            setTimeout(() => {
                submitBtn.prop('disabled', false).text(originalText);
                $(phoneInput).attr('name', 'whatsapp_phone'); // Restore name attribute
            }, 10000);
            
            form.submit();
        }
    });

    // Custom validation for destination country (cannot be same as origin)
    $('#destination_country').on('change', function() {
        const originCountry = $('#origin_country').val();
        const destinationCountry = $(this).val();
        
        if (originCountry && destinationCountry && originCountry === destinationCountry) {
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">Destination country cannot be the same as origin country</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Remove server-side errors on input change
    $('.form-control, .form-select').on('input change', function() {
        if ($(this).hasClass('is-invalid') && $(this).val()) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });

    // Special handling for phone input
    $(phoneInput).on('input keyup', function() {
        if ($(this).hasClass('is-invalid') && iti.isValidNumber()) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });
});
</script>
@endsection