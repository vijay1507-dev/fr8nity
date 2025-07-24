@extends('layouts.dashboard')

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
                                id="region" name="region_id" >
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.date-picker-wrapper {
    position: relative;
}
.calendar-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #6c757d;
}
.country-option {
    display: flex;
    align-items: center;
    gap: 10px;
}
.country-flag {
    width: 20px;
    height: auto;
}
.select2-container .select2-selection--single {
    height: 38px;
    border-color: #dee2e6;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #435ebe;
}

.iti {
    width: 100%;
}
.iti__flag {
    background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/img/flags.png");
}
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .iti__flag {
        background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/img/flags@2x.png");
    }
}

/* Remove red border from error fields */
.form-control.is-invalid,
.form-select.is-invalid,
.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
    border-color: #dee2e6 !important;
    background-image: none !important;
}

.select2-container--default .select2-selection--single.is-invalid {
    border-color: #dee2e6 !important;
}

.invalid-feedback {
    color: #dc3545 !important;
    margin-top: 0.25rem;
}

/* Toastr customization */
.toast-success {
    background-color: #51A351 !important;
}
#toast-container > .toast-success {
    background-image: none !important;
}
#toast-container > div {
    padding: 15px 15px 15px 15px;
    width: 300px;
    opacity: 1;
    border-radius: 4px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add error handling functions
    function showError(element, message) {
        element.addClass('is-invalid');
        
        if (element.hasClass('select2-hidden-accessible')) {
            const select2Container = element.next('.select2-container');
            select2Container.find('.select2-selection').addClass('is-invalid');
            select2Container.next('.invalid-feedback').remove();
            select2Container.after(`<div class="invalid-feedback d-block text-danger">${message}</div>`);
        } else {
            element.siblings('.invalid-feedback').remove();
            element.after(`<div class="invalid-feedback d-block text-danger">${message}</div>`);
        }
    }

    function removeError(element) {
        element.removeClass('is-invalid');
        if (element.hasClass('select2-hidden-accessible')) {
            const select2Container = element.next('.select2-container');
            select2Container.find('.select2-selection').removeClass('is-invalid');
            select2Container.next('.invalid-feedback').remove();
        } else {
            element.siblings('.invalid-feedback').remove();
        }
    }

    function validateForm() {
        let isValid = true;
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
        
        const requiredFields = [
            { name: 'name', label: 'Name' },
            { name: 'designation', label: 'Designation' },
            { name: 'email', label: 'Email' },
            { name: 'whatsapp_phone', label: 'WhatsApp/Phone' },
            { name: 'company_name', label: 'Company Name' },
            { name: 'company_telephone', label: 'Company Telephone' },
            { name: 'company_address', label: 'Company Address' },
            { name: 'country_id', label: 'Country' },
            { name: 'city_id', label: 'City' },
            { name: 'region_id', label: 'Region' },
            { name: 'incorporation_date', label: 'Incorporation Date' },
            { name: 'tax_id', label: 'Tax ID' },
            { name: 'website_linkedin', label: 'Website / LinkedIn' },
            { name: 'membership_tier', label: 'Membership Tier' }
        ];

        // Check all required fields
        requiredFields.forEach(field => {
            const input = $(`[name="${field.name}"]`);
            if (!input.val()) {
                showError(input, `${field.label} is required`);
                isValid = false;
            }
        });

        // Check specializations
        if (!$('input[name="specializations[]"]:checked').length) {
            const container = $('input[name="specializations[]"]').closest('.bg-light');
            container.addClass('is-invalid');
            container.after('<div class="invalid-feedback d-block text-danger">Please select at least one specialization</div>');
            isValid = false;
        }

        // Check network member radio
        if (!$('input[name="is_network_member"]:checked').length) {
            const container = $('input[name="is_network_member"]').closest('.bg-light');
            container.addClass('is-invalid');
            container.after('<div class="invalid-feedback d-block text-danger">Please select whether you are a member of any other network</div>');
            isValid = false;
        } else if ($('input[name="is_network_member"]:checked').val() === 'yes') {
            const networkNameInput = $('input[name="network_name"]');
            if (!networkNameInput.val()) {
                showError(networkNameInput, 'Please enter the network name');
                isValid = false;
            }
        }

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const email = $('input[name="email"]');
        if (email.val() && !emailRegex.test(email.val())) {
            showError(email, 'Please enter a valid email address');
            isValid = false;
        }

        if (!isValid) {
            // Scroll to the first invalid field
            const firstInvalid = $('.is-invalid:first');
            if (firstInvalid.length) {
                $('html, body').animate({
                    scrollTop: firstInvalid.offset().top - 100
                }, 500);
            }
        }

        return isValid;
    }

    // Remove invalid state and error message on input change
    $('input, select').on('input change', function() {
        removeError($(this));
        if ($(this).is(':checkbox') || $(this).is(':radio')) {
            const container = $(this).closest('.bg-light');
            container.removeClass('is-invalid');
            container.siblings('.invalid-feedback').remove();
        }
    });

    // Initialize Flatpickr for date input
    flatpickr("#incorporation_date", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        disableMobile: "true",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",
        animate: true
    });

    // Initialize Select2 for country dropdown
    $('#country').select2({
        theme: 'default',
        placeholder: 'Select Country',
        allowClear: true,
        width: '100%',
        templateResult: formatCountryOption,
        templateSelection: formatCountryOption
    }).on('select2:clearing', function(e) {
        e.preventDefault();
        $(this).val(null).trigger('change');
        $('#city').val(null).trigger('change').prop('disabled', true);
    });

    // Initialize Select2 for city dropdown
    $('#city').select2({
        theme: 'default',
        placeholder: 'Select City',
        allowClear: true,
        width: '100%'
    }).on('select2:clearing', function(e) {
        e.preventDefault();
        $(this).val(null).trigger('change');
    });

    function formatCountryOption(country) {
        if (!country.id) {
            return country.text;
        }
        let $option = $(country.element);
        let $content = $($option.html());
        return $content;
    }

    // Load countries on page load
    $.get('/get-countries', function(data) {
        let countrySelect = $('#country');
        let oldCountryId = countrySelect.data('old');
        
        data.forEach(function(country) {
            let option = new Option(country.name, country.id);
            $(option).data('code', country.code); // Store country code in data attribute
            $(option).html(`<div class="country-option">
                <img src="https://flagcdn.com/w40/${country.code.toLowerCase()}.png" 
                     class="country-flag" 
                     alt="${country.name} flag">
                <span>${country.name}</span>
            </div>`);
            countrySelect.append(option);
        });

        // Set old value if exists
        if (oldCountryId) {
            countrySelect.val(oldCountryId).trigger('change');
            // Load cities for the selected country
            loadCities(oldCountryId);
        }
    });

    // Function to load cities
    function loadCities(countryId) {
        let citySelect = $('#city');
        let oldCityId = citySelect.data('old');

        // Reset and disable city
        citySelect.empty().append('<option value="">Select City</option>').prop('disabled', !countryId);

        if (countryId) {
            // Load cities based on selected country
            $.get('/get-cities/' + countryId, function(data) {
                data.forEach(function(city) {
                    let option = new Option(city.name, city.id);
                    citySelect.append(option);
                });

                // Set old value if exists
                if (oldCityId) {
                    citySelect.val(oldCityId).trigger('change');
                }
            });
        }
    }

    // Handle country change
    $('#country').on('change', function() {
        let countryId = $(this).val();
        loadCities(countryId);
    });

    // Handle network member radio buttons
    const networkRadios = document.querySelectorAll('input[name="is_network_member"]');
    const networkField = document.getElementById('networkField');

    networkRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            networkField.style.display = this.value === 'yes' ? 'block' : 'none';
        });
    });

    // Initialize regions
    fetch("{{ route('get.regions') }}")
        .then(response => response.json())
        .then(data => {
            const regionSelect = document.getElementById('region');
            data.forEach(region => {
                const option = new Option(region.name, region.id);
                regionSelect.add(option);
            });
        });

    // Initialize international telephone input for both phone fields
    const phoneInputs = document.querySelectorAll('.iti__tel-input');
    const phoneInstances = [];

    phoneInputs.forEach(function(input) {
        const iti = window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("US"));
            },
            formatOnDisplay: true,
            autoPlaceholder: "polite"
        });

        // Store instance for later use
        phoneInstances.push(iti);

        // Handle validation
        input.addEventListener('blur', function() {
            if (input.value.trim()) {
                if (iti.isValidNumber()) {
                    const nationalNumber = iti.getNumber().replace('+' + iti.getSelectedCountryData().dialCode, '');
                    input.value = nationalNumber;
                    removeError($(input));
                } else {
                    showError($(input), 'Please enter a valid phone number');
                }
            }
        });

        // Clear error on input
        input.addEventListener('input', function() {
            removeError($(input));
        });

        // Handle country change
        input.addEventListener('countrychange', function() {
            removeError($(input));
            if (input.value.trim()) {
                const nationalNumber = iti.getNumber().replace('+' + iti.getSelectedCountryData().dialCode, '');
                input.value = nationalNumber;
            }
        });
    });

    // Configure toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Show success message if exists
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Form submission handler
    $('form').on('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            // Add complete phone numbers with country code before submission
            phoneInputs.forEach(function(input, index) {
                const iti = phoneInstances[index];
                if (input.value.trim()) {
                    input.value = iti.getNumber();
                }
            });
            
            // Submit the form
            const form = this;
            $.ajax({
                url: form.action,
                method: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    // Store success message in session storage
                    sessionStorage.setItem('successMessage', 'Member added successfully!');
                    // Redirect to members index
                    window.location.href = "{{ route('members.index') }}";
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            const input = $(`[name="${key}"]`);
                            showError(input, errors[key][0]);
                        });
                    } else {
                        toastr.error('An error occurred while adding the member');
                    }
                }
            });
        }
    });
});
</script>
@endsection 