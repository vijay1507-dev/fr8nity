    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
        // Initialize international telephone input for phone field
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
                    },
                    formatOnDisplay: true,
                    autoPlaceholder: "polite"
                });

        // Custom validation method for phone number
        $.validator.addMethod("validPhoneNumber", function(value, element) {
            if (!value.trim()) return true; // Let required handle empty validation
            return iti.isValidNumber();
        }, "Please enter a valid phone number");

        // Handle phone validation
        phoneInput.addEventListener('blur', function() {
            if (this.value.trim()) {
                if (iti.isValidNumber()) {
                    // Show only national number in input
                    const nationalNumber = iti.getNumber().replace('+' + iti.getSelectedCountryData().dialCode, '');
                    this.value = nationalNumber;
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                } else {
                    $(this).addClass('is-invalid');
                    if (!$(this).siblings('.invalid-feedback').length) {
                        $('<div class="invalid-feedback d-block text-danger">Please enter a valid phone number</div>').insertAfter(this);
                    }
                }
            }
        });

        // Clear phone error on input
        phoneInput.addEventListener('input', function() {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        });

        // Initialize Select2 for country dropdowns
        ['origin', 'destination'].forEach(function(type) {
            // Initialize country dropdown
            $(`#${type}_country`).select2({
            theme: 'default',
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%',
            templateResult: formatCountryOption,
            templateSelection: formatCountryOption
        }).on('select2:clear', function(e) {
            e.preventDefault();
            $(this).val(null).trigger('change');
            });

            // Load countries
        $.get('/get-countries', function(data) {
                let countrySelect = $(`#${type}_country`);
            let oldCountryId = countrySelect.data('old');
                
                // Clear existing options
                countrySelect.empty().append('<option value="">Select Country</option>');
            
            data.forEach(function(country) {
                let option = new Option(country.name, country.id);
                    $(option).data('code', country.code);
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
                }
            });
        });

        // Format country options
        function formatCountryOption(country) {
            if (!country.id) {
                return country.text;
            }
            let $option = $(country.element);
            let $content = $($option.html());
            return $content;
        }

        // Custom validation method for checkbox groups
        $.validator.addMethod("checkboxGroup", function(value, element, param) {
            return $(param).filter(':checked').length > 0;
        }, "Please select at least one option");

        // Initialize form validation
        $("#joinMemberForm").validate({
            ignore: [],
            errorElement: 'div',
            errorClass: 'invalid-feedback d-block text-danger',
            highlight: function(element) {
                $(element).addClass('is-invalid');
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.attr('type') === 'checkbox') {
                    error.insertAfter(element.closest('.checkbox-group'));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                'company_name': {
                    required: true,
                    minlength: 2
                },
                'product_industry_category': {
                    required: true,
                    minlength: 2
                },
                'shipping_frequency[]': {
                    checkboxGroup: 'input[name="shipping_frequency[]"]'
                },
                'mode_of_shipment[]': {
                    checkboxGroup: 'input[name="mode_of_shipment[]"]'
                },
                'origin_country': {
                    required: true
                },
                'destination_country': {
                    required: true
                },
                'estimated_shipment_volume': {
                    required: true
                },
                'looking_for[]': {
                    checkboxGroup: 'input[name="looking_for[]"]'
                },
                'name': {
                    required: true,
                    minlength: 2
                },
                'designation': {
                    required: true,
                    minlength: 2
                },
                'email': {
                    required: true,
                    email: true
                },
                'whatsapp_phone': {
                    required: true,
                    validPhoneNumber: true
                },
                'consent': {
                    required: true
                }
            },
            messages: {
                'company_name': {
                    required: 'Please enter your company name',
                    minlength: 'Company name must be at least 2 characters long'
                },
                'product_industry_category': {
                    required: 'Please enter your product/industry category',
                    minlength: 'Category must be at least 2 characters long'
                },
                'shipping_frequency[]': {
                    checkboxGroup: 'Please select at least one shipping frequency'
                },
                'mode_of_shipment[]': {
                    checkboxGroup: 'Please select at least one mode of shipment'
                },
                'origin_country': {
                    required: 'Please select origin country'
                },
                'destination_country': {
                    required: 'Please select destination country'
                },
                'estimated_shipment_volume': {
                    required: 'Please enter estimated shipment volume'
                },
                'looking_for[]': {
                    checkboxGroup: 'Please select what you are looking for'
                },
                'name': {
                    required: 'Please enter your name',
                    minlength: 'Name must be at least 2 characters long'
                },
                'designation': {
                    required: 'Please enter your designation',
                    minlength: 'Designation must be at least 2 characters long'
                },
                'email': {
                    required: 'Please enter your email address',
                    email: 'Please enter a valid email address'
                },
                'whatsapp_phone': {
                    required: 'Please enter your WhatsApp/Phone number',
                    validPhoneNumber: 'Please enter a valid phone number'
                },
                'consent': {
                    required: 'Please accept the consent'
                }
            },
            invalidHandler: function(event, validator) {
                // Prevent form submission when there are errors
                event.preventDefault();
                
                // Ensure phone validation message is shown
                if (phoneInput.value.trim() && !iti.isValidNumber()) {
                    $(phoneInput).addClass('is-invalid');
                    if (!$(phoneInput).siblings('.invalid-feedback').length) {
                        $('<div class="invalid-feedback d-block text-danger">Please enter a valid phone number</div>').insertAfter(phoneInput);
                    }
                }
            },
            submitHandler: function(form) {
                // Set the full formatted number with country code before submit
                if (phoneInput.value.trim()) {
                    phoneInput.value = iti.getNumber(); // This will include the country code with +
                }

                // Submit the form
                form.submit();
            }
        });

        // Add validation for Select2 fields
        $('select.select2').on('change', function() {
            $(this).valid();
        });

        // Prevent form submission on enter key
        $('#joinMemberForm').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                return false;
            }
        });
        });
    });