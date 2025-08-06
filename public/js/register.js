document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
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
                        // Get only the national number without country code for display
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
                // If there's a value, update it to remove country code
                if (input.value.trim()) {
                    const nationalNumber = iti.getNumber().replace('+' + iti.getSelectedCountryData().dialCode, '');
                    input.value = nationalNumber;
                }
            });
        });

        var allWells = $('.setup-content'); // All steps
        var allNextBtn = $('.nextBtn'); // Next buttons
        var allBackBtn = $('.backBtn'); // Back buttons
        var progressBar = $('.progress-bar');
        var progressSteps = $('.progress-step');

        allWells.hide(); // Hide all steps initially
        $('#step-1').show(); // Show the first step
        updateProgress(1); // Initialize progress

        function updateProgress(step) {
            const totalSteps = 2;
            const progress = (step / totalSteps) * 100;
            progressBar.css('width', progress + '%');
            progressBar.attr('aria-valuenow', progress);

            // Update step labels
            progressSteps.removeClass('active');
            progressSteps.eq(step - 1).addClass('active');
        }

        // Update showError function to handle Select2 fields
        function showError(element, message) {
            element.addClass('is-invalid');
            
            // Remove all existing error messages for this element
            if (element.hasClass('select2-hidden-accessible')) {
                const select2Container = element.next('.select2-container');
                select2Container.find('.select2-selection').addClass('is-invalid');
                // Remove any existing error messages
                select2Container.next('.invalid-feedback').remove();
                select2Container.after(`<div class="invalid-feedback d-block text-danger">${message}</div>`);
            } else {
                // Remove any existing error messages
                element.siblings('.invalid-feedback').remove();
                element.after(`<div class="invalid-feedback d-block text-danger">${message}</div>`);
            }
        }

        // Update removeError function to handle Select2 fields
        function removeError(element) {
            element.removeClass('is-invalid');
            // Special handling for Select2 fields
            if (element.hasClass('select2-hidden-accessible')) {
                const select2Container = element.next('.select2-container');
                select2Container.find('.select2-selection').removeClass('is-invalid');
                select2Container.next('.invalid-feedback').remove();
            } else {
                element.siblings('.invalid-feedback').remove();
            }
        }

        function validateStep1() {
            let isValid = true;
            // Remove all existing error messages before validation
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
                { name: 'website_linkedin', label: 'Website / LinkedIn' }
            ];

            // Check all required text/select fields
            requiredFields.forEach(field => {
                const input = $(`[name="${field.name}"]`);
                if (!input.val()) {
                    showError(input, `${field.label} is required`);
                    isValid = false;
                }
            });

            // Check specializations
            const specializationsContainer = $('input[name="specializations[]"]').closest('.bg-black');
            if (!$('input[name="specializations[]"]:checked').length) {
                specializationsContainer.addClass('is-invalid');
                // Remove any existing error message before adding new one
                specializationsContainer.siblings('.invalid-feedback').remove();
                specializationsContainer.after('<div class="invalid-feedback d-block text-danger">Please select at least one specialization</div>');
                isValid = false;
            }

            // Check is_network_member radio
            const networkMemberContainer = $('input[name="is_network_member"]').closest('.bg-black');
            if (!$('input[name="is_network_member"]:checked').length) {
                networkMemberContainer.addClass('is-invalid');
                // Remove any existing error message before adding new one
                networkMemberContainer.siblings('.invalid-feedback').remove();
                networkMemberContainer.after('<div class="invalid-feedback d-block text-danger">Please select whether you are a member of any other network</div>');
                isValid = false;
            } else {
                // If "yes" is selected, validate network_name
                if ($('input[name="is_network_member"]:checked').val() === 'yes') {
                    const networkNameInput = $('input[name="network_name"]');
                    if (!networkNameInput.val()) {
                        showError(networkNameInput, 'Please enter the network name');
                        isValid = false;
                    }
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

        function validateStep2() {
            let isValid = true;
            // Remove all existing error messages before validation
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            // Validate membership tier selection
            if (!$('input[name="membership_tier"]:checked').length) {
                const membershipContainer = $('input[name="membership_tier"]').closest('.row');
                membershipContainer.addClass('is-invalid');
                membershipContainer.after('<div class="invalid-feedback d-block text-danger">Please select a membership tier</div>');
                isValid = false;
            }

            // Validate consent checkbox
            const consentCheckbox = $('#consentCheckbox');
            if (!consentCheckbox.is(':checked')) {
                consentCheckbox.addClass('is-invalid');
                // Remove any existing error message before adding new one
                consentCheckbox.closest('.form-check').find('.invalid-feedback').remove();
                consentCheckbox.closest('.form-check').append('<div class="invalid-feedback d-block text-danger">You must agree to the terms and conditions</div>');
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

        // Handle form submission
        $('form').on('submit', function(e) {
            if (!validateStep2()) {
                e.preventDefault(); // Prevent form submission if validation fails
                return;
            }

            // Add complete phone numbers with country code before submission
            phoneInputs.forEach(function(input, index) {
                const iti = phoneInstances[index];
                if (input.value.trim()) {
                    // Get the full number with country code
                    input.value = iti.getNumber();
                }
            });
        });

        // Prevent multiple clicks on next button
        allNextBtn.click(function(e) {
            e.preventDefault(); // Prevent default button behavior
            
            var curStep = $(this).closest(".setup-content");
            var nextStep = curStep.next('.setup-content');

            if (nextStep.length === 0) {
                console.error("Next step not found!");
                return;
            }

            if (validateStep1()) {
                curStep.hide();
                nextStep.show();
                updateProgress(2); // Update progress to step 2
            }
        });

        allBackBtn.click(function() {
            var curStep = $(this).closest(".setup-content");
            var prevStep = curStep.prev('.setup-content');

            curStep.hide();
            prevStep.show();
            updateProgress(1); // Update progress back to step 1
        });

        // Remove invalid state and error message on input change
        $('input, select').on('input change', function() {
            removeError($(this));
            // For checkbox/radio groups, remove invalid state from container
            if ($(this).is(':checkbox') || $(this).is(':radio')) {
                const container = $(this).closest('.bg-black, .form-check');
                container.removeClass('is-invalid');
                container.find('.invalid-feedback').remove();
                container.siblings('.invalid-feedback').remove(); // Remove sibling error messages
            }
        });

        // Special handling for checkbox groups
        $('input[name="specializations[]"]').on('change', function() {
            const container = $(this).closest('.bg-black');
            if ($('input[name="specializations[]"]:checked').length > 0) {
                container.removeClass('is-invalid');
                container.siblings('.invalid-feedback').remove();
            }
        });

        // Add Select2 change event handler
        $('#country, #city, #region').on('change', function() {
            const $this = $(this);
            if ($this.val()) {
                removeError($this);
            }
        });
    });
});

$(document).ready(function() {
    $(".table_head").click(function() {
        $(this).next(".table_tbody").toggle();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const yesRadio = document.getElementById('currentlyYes');
    const noRadio = document.getElementById('currentlyNo');
    const networkField = document.getElementById('networkField');

    function toggleNetworkField() {
        if (yesRadio.checked) {
            networkField.style.display = '';
        } else {
            networkField.style.display = 'none';
        }
    }

    yesRadio.addEventListener('change', toggleNetworkField);
    noRadio.addEventListener('change', toggleNetworkField);
});

$(document).ready(function() {
    // Initialize Select2 for country dropdown
    $('#country').select2({
        theme: 'default',
        placeholder: 'Select Country',
        allowClear: true,
        width: '100%',
        templateResult: formatCountryOption,
        templateSelection: formatCountryOption
    }).on('select2:clear', function(e) {
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
    }).on('select2:clear', function(e) {
        $(this).val(null).trigger('change');
    });

    // Initialize Select2 for region dropdown
    $('#region').select2({
        theme: 'default',
        placeholder: 'Select Region',
        allowClear: true,
        width: '100%'
    }).on('select2:clear', function(e) {
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

        // Set default country if no old value exists
        if (!oldCountryId) {
            countrySelect.val(window.defaults.default_country_id);
            loadCities(window.defaults.default_country_id);
        } else {
            countrySelect.val(oldCountryId);
            loadCities(oldCountryId);
        }

        // Set country code for selected value
        const selectedOption = countrySelect.find('option:selected');
        if (selectedOption.length) {
            $('#country_code').val(selectedOption.data('code'));
        }
    });

    // Handle country change
    $('#country').on('change', function() {
        let countryId = $(this).val();
        if (countryId) {
            // Set country code when country is selected
            const selectedOption = $(this).find('option:selected');
            $('#country_code').val(selectedOption.data('code'));
            // Load cities when country changes
            loadCities(countryId);
        } else {
            // Clear country code when no country is selected
            $('#country_code').val('');
            // Reset city dropdown
            let citySelect = $('#city');
            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
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

                // Set default city if country is Singapore
                if (countryId == window.defaults.default_country_id) {
                    citySelect.val(window.defaults.default_city_id).trigger('change');
                    $('#country_code').val(window.defaults.default_country_code);
                }

                // Set old value if exists
                if (oldCityId) {
                    citySelect.val(oldCityId).trigger('change');
                }
            });
        }
    }

    // Load regions on page load
    $.get('/get-regions', function(data) {
        let regionSelect = $('#region');
        let oldRegionId = regionSelect.data('old');
        
        data.forEach(function(region) {
            let option = new Option(region.name, region.id);
            regionSelect.append(option);
        });

        // Set old value if exists
        if (oldRegionId) {
            regionSelect.val(oldRegionId).trigger('change');
        }
    });
});

$(document).ready(function() {
    // Initialize Flatpickr
    flatpickr("#incorporation_date", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        disableMobile: "true",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",
        animate: true,
        onChange: function(selectedDates, dateStr, instance) {
            // Optional: Add any validation or additional logic here
            if (selectedDates[0]) {
                instance.element.classList.add('is-valid');
            }
        }
    });
});