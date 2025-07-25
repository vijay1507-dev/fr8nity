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