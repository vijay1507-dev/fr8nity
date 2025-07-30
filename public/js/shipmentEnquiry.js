
$(document).ready(function() {
    // Initialize Flatpickr
    flatpickr("#cargo_ready_date", {
        dateFormat: "Y-m-d",
        // maxDate: "today",
        disableMobile: "true",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",
        animate: true,
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates[0]) {
                instance.element.classList.add('is-valid');
            }
        }
    });

    // Common function to format country options
    function formatCountryOption(country) {
        if (!country.id) {
            return country.text;
        }
        let $option = $(country.element);
        let $content = $($option.html());
        return $content;
    }

    // Initialize Select2 for all country and city dropdowns
    ['pickup', 'destination'].forEach(function(type) {
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
            $(`#${type}_city`).val(null).trigger('change').prop('disabled', true);
        });

        // Initialize city dropdown
        $(`#${type}_city`).select2({
            theme: 'default',
            placeholder: 'Select City',
            allowClear: true,
            width: '100%'
        }).on('select2:clear', function(e) {
            e.preventDefault();
            $(this).val(null).trigger('change');
        });

        // Load cities for the specific type (pickup/destination)
        function loadCities(countryId, type) {
            let citySelect = $(`#${type}_city`);
            let oldCityId = citySelect.data('old');

            // Reset and disable city dropdown
            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', !countryId);

            if (countryId) {
                $.get(`/get-cities/${countryId}`, function(data) {
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
                loadCities(oldCountryId, type);
            }
        });

        // Handle country change
        $(`#${type}_country`).on('change', function() {
            let countryId = $(this).val();
            loadCities(countryId, type);
        });
    });

    // Form validation
    $("form").validate({
        ignore: [],
        errorElement: 'div',
        errorClass: 'invalid-feedback d-block text-danger',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') || element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.attr('type') === 'checkbox') {
                error.insertAfter(element.closest('.checkbox-group'));
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            'shipment_type[]': {
                required: true,
                minlength: 1
            },
            'mode_of_transport': {
                required: true
            },
            'goods_description': {
                required: true,
                minlength: 3
            },
            'estimated_volume': {
                required: true
            },
            'cargo_ready_date': {
                required: true
            },
            'pickup_country_id': {
                required: true
            },
            'pickup_city_id': {
                required: true
            },
            'destination_country_id': {
                required: true
            },
            'destination_city_id': {
                required: true
            },
            'consent': {
                required: true
            }
        },
        messages: {
            'shipment_type[]': {
                required: 'Please select at least one shipment type',
                minlength: 'Please select at least one shipment type'
            },
            'mode_of_transport': {
                required: 'Please select mode of transport'
            },
            'goods_description': {
                required: 'Please enter goods description',
                minlength: 'Description must be at least 3 characters long'
            },
            'estimated_volume': {
                required: 'Please enter estimated volume/weight'
            },
            'cargo_ready_date': {
                required: 'Please select cargo ready date'
            },
            'pickup_country_id': {
                required: 'Please select pickup country'
            },
            'pickup_city_id': {
                required: 'Please select pickup city'
            },
            'destination_country_id': {
                required: 'Please select destination country'
            },
            'destination_city_id': {
                required: 'Please select destination city'
            },
            'consent': {
                required: 'Please accept the consent'
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});