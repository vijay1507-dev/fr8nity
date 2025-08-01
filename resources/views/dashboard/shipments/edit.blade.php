@extends('layouts.dashboard')
@section('title', 'Edit Shipment Enquiry')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Shipment Enquiry</h4>
                <div>
                    <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('shipments.update', $shipment) }}" method="POST" enctype="multipart/form-data" id="editShipmentForm">
                @csrf
                @method('PATCH')
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Contact Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $shipment->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label required">Email ID <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $shipment->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label required">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control iti__tel-input @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $shipment->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label required">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                   name="company_name" value="{{ old('company_name', $shipment->company_name) }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Shipment Information</h5>
                        
                        <div class="mb-3">
                            <label for="shipment_type" class="form-label required">Shipment Types <span class="text-danger">*</span></label>
                            @php
                                $types = $shipment->shipment_type;
                                if (is_string($types)) {
                                    $types = json_decode($types, true);
                                }
                                $types = is_array($types) ? $types : [];
                                $oldTypes = old('shipment_type', $types);
                            @endphp
                            <div class="checkbox-group bg-light p-2 rounded @error('shipment_type') is-invalid @enderror">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shipment_type[]" value="FCL" id="fcl" 
                                        {{ in_array('FCL', $oldTypes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fcl">FCL (Full Container Load)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shipment_type[]" value="LCL" id="lcl"
                                        {{ in_array('LCL', $oldTypes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lcl">LCL (Less Container Load)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shipment_type[]" value="Air Freight" id="air"
                                        {{ in_array('Air Freight', $oldTypes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="air">Air Freight</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shipment_type[]" value="Road Transport" id="road"
                                        {{ in_array('Road Transport', $oldTypes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="road">Road Transport</label>
                                </div>
                            </div>
                            @error('shipment_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mode_of_transport" class="form-label required">Mode of Transport <span class="text-danger">*</span></label>
                            <select class="form-select @error('mode_of_transport') is-invalid @enderror" name="mode_of_transport" >
                                <option value="">Select Mode of Transport</option>
                                <option value="Sea Freight" {{ old('mode_of_transport', $shipment->mode_of_transport) == 'Sea Freight' ? 'selected' : '' }}>Sea Freight</option>
                                <option value="Air Freight" {{ old('mode_of_transport', $shipment->mode_of_transport) == 'Air Freight' ? 'selected' : '' }}>Air Freight</option>
                                <option value="Road Transport" {{ old('mode_of_transport', $shipment->mode_of_transport) == 'Road Transport' ? 'selected' : '' }}>Road Transport</option>
                                <option value="Rail Transport" {{ old('mode_of_transport', $shipment->mode_of_transport) == 'Rail Transport' ? 'selected' : '' }}>Rail Transport</option>
                                <option value="Multimodal" {{ old('mode_of_transport', $shipment->mode_of_transport) == 'Multimodal' ? 'selected' : '' }}>Multimodal</option>
                            </select>
                            @error('mode_of_transport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="goods_description" class="form-label required">Goods Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('goods_description') is-invalid @enderror" name="goods_description" rows="3" >{{ old('goods_description', $shipment->goods_description) }}</textarea>
                            @error('goods_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estimated_volume" class="form-label required">Estimated Volume <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('estimated_volume') is-invalid @enderror" name="estimated_volume" value="{{ old('estimated_volume', $shipment->estimated_volume) }}" >
                            @error('estimated_volume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cargo_ready_date" class="form-label required">
                                Cargo Ready Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="cargo_ready_date"
                                   class="form-control @error('cargo_ready_date') is-invalid @enderror"
                                   name="cargo_ready_date"
                                   value="{{ old('cargo_ready_date', $shipment->cargo_ready_date ? $shipment->cargo_ready_date->format('Y-m-d') : '') }}"
                                   placeholder="Select Date">
                            @error('cargo_ready_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Location Details</h5>
                        
                        <div class="mb-3">
                            <label for="pickup_country_id" class="form-label required">Pickup Country <span class="text-danger">*</span></label>
                            <select class="form-select @error('pickup_country_id') is-invalid @enderror"  
                                    name="pickup_country_id" id="pickup_country_id" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" 
                                            data-flag="{{ strtolower($country->code) }}"
                                            {{ old('pickup_country_id', $shipment->pickup_country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pickup_country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pickup_city_id" class="form-label required">Pickup City <span class="text-danger">*</span></label>
                            <select class="form-select @error('pickup_city_id') is-invalid @enderror" name="pickup_city_id" id="pickup_city_id" >
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    @if($city->country_id == $shipment->pickup_country_id)
                                        <option value="{{ $city->id }}" {{ old('pickup_city_id', $shipment->pickup_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('pickup_city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination_country_id" class="form-label required">Destination Country <span class="text-danger">*</span></label>
                            <select class="form-select @error('destination_country_id') is-invalid @enderror"  
                                    name="destination_country_id" id="destination_country_id" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" 
                                            data-flag="{{ strtolower($country->code) }}"
                                            {{ old('destination_country_id', $shipment->destination_country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination_city_id" class="form-label required">Destination City <span class="text-danger">*</span></label>
                            <select class="form-select @error('destination_city_id') is-invalid @enderror" name="destination_city_id" id="destination_city_id" >
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    @if($city->country_id == $shipment->destination_country_id)
                                        <option value="{{ $city->id }}" {{ old('destination_city_id', $shipment->destination_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('destination_city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">Documents</label>
                            <input type="file" class="form-control @error('documents') is-invalid @enderror" name="documents" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Max file size: 10MB. Supported formats: PDF, DOC, DOCX, JPG, PNG</small>
                            @if($shipment->documents)
                                <div class="mt-2">
                                    <small class="text-muted">Current document: <a href="{{ Storage::url($shipment->documents) }}" target="_blank">View Document</a></small>
                                </div>
                            @endif
                            @error('documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Additional Information</h5>
                        
                        <div class="mb-3">
                            <label for="special_notes" class="form-label">Special Notes</label>
                            <textarea class="form-control @error('special_notes') is-invalid @enderror" name="special_notes" rows="3">{{ old('special_notes', $shipment->special_notes) }}</textarea>
                            @error('special_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_remark" class="form-label">Delivery Remarks</label>
                            <textarea class="form-control @error('delivery_remark') is-invalid @enderror" name="delivery_remark" rows="3">{{ old('delivery_remark', $shipment->delivery_remark) }}</textarea>
                            @error('delivery_remark')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Shipment Enquiry
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Initialize international telephone input
    const phoneInput = document.querySelector("#phone");
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

    // Handle validation
    phoneInput.addEventListener('blur', function() {
        if (phoneInput.value.trim()) {
            if (iti.isValidNumber()) {
                // Show only national number in input
                phoneInput.value = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL).replace(/[^\d]/g, '');
                $(phoneInput).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(phoneInput).removeClass('is-valid').addClass('is-invalid');
                showError($(phoneInput), 'Please enter a valid phone number');
            }
        }
    });

    // Clear error on input
    phoneInput.addEventListener('input', function() {
        $(phoneInput).removeClass('is-invalid is-valid');
        removeError($(phoneInput));
    });

    // Helper functions for error handling
    function showError($element, message) {
        removeError($element);
        $element.addClass('is-invalid');
        $('<div class="invalid-feedback d-block text-danger">' + message + '</div>').insertAfter($element);
    }

    function removeError($element) {
        $element.removeClass('is-invalid');
        $element.next('.invalid-feedback').remove();
    }
    // Custom validation method for checkboxes
    $.validator.addMethod("checkboxRequired", function(value, element) {
        return $('input[name="' + element.name + '"]:checked').length > 0;
    }, "Please select at least one option.");

    // Custom validation method for file size
    $.validator.addMethod("filesize", function(value, element, param) {
        if (element.files.length === 0) return true;
        return element.files[0].size <= param;
    }, "File size must be less than 10MB.");

    // Handle form submission
    $("#editShipmentForm").on('submit', function(e) {
        e.preventDefault();
        if (iti.isValidNumber()) {
            phoneInput.value = iti.getNumber(); // Set the full international number
        }
        this.submit();
    });

    // Form validation
    const validator = $("#editShipmentForm").validate({
        ignore: [],
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertAfter(element.closest('.checkbox-group'));
            } else if (element.attr("type") == "tel") {
                // For phone input, place error after the parent div to appear below flag
                error.insertAfter(element.closest('.iti'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
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
        rules: {
            'name': { required: true, minlength: 2, maxlength: 255 },
            'email': { required: true, email: true, maxlength: 255 },
            'phone': { required: true, phoneValid: true },
            'company_name': { required: true, minlength: 2, maxlength: 255 },
            'shipment_type[]': { checkboxRequired: true },
            'mode_of_transport': { required: true },
            'goods_description': { required: true, minlength: 10, maxlength: 1000 },
            'estimated_volume': { required: true, maxlength: 255 },
            'cargo_ready_date': { required: true, date: true },
            'pickup_country_id': { required: true },
            'pickup_city_id': { required: true },
            'destination_country_id': { required: true },
            'destination_city_id': { required: true, differentLocation: true },
            'documents': { filesize: 10485760 },
            'special_notes': { maxlength: 1000 },
            'delivery_remark': { maxlength: 1000 },
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
            'phone': { 
                required: "Phone number is required",
                minlength: "Phone number must be at least 10 digits",
                maxlength: "Phone number cannot exceed 20 digits"
            },
            'company_name': { 
                required: "Company name is required",
                minlength: "Company name must be at least 2 characters long",
                maxlength: "Company name cannot exceed 255 characters"
            },
            'shipment_type[]': { checkboxRequired: "Please select at least one shipment type" },
            'mode_of_transport': { required: "Mode of transport is required" },
            'goods_description': { required: "Goods description is required", minlength: "Description must be at least 10 characters long", maxlength: "Description cannot exceed 1000 characters" },
            'estimated_volume': { required: "Estimated volume is required", maxlength: "Volume cannot exceed 255 characters" },
            'cargo_ready_date': { required: "Cargo ready date is required", date: "Please enter a valid date" },
            'pickup_country_id': { required: "Pickup country is required" },
            'pickup_city_id': { required: "Pickup city is required" },
            'destination_country_id': { required: "Destination country is required" },
            'destination_city_id': { required: "Destination city is required", differentLocation: "Destination cannot be the same as pickup location" },
            'documents': { filesize: "File size must be less than 10MB" },
            'special_notes': { maxlength: "Special notes cannot exceed 1000 characters" },
            'delivery_remark': { maxlength: "Delivery remarks cannot exceed 1000 characters" },
        },
        submitHandler: function(form) {
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            return true;
        }
    });
    // Initialize Flatpickr for Cargo Ready Date
    flatpickr("#cargo_ready_date", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ old('cargo_ready_date', $shipment->cargo_ready_date ? $shipment->cargo_ready_date->format('Y-m-d') : '') }}",
    });
    // Function to format country option with flag
    function formatCountry(option) {
        if (!option.id) return option.text;
        var flagCode = $(option.element).data('flag');
        if (!flagCode) return option.text;
        return $('<span><img src="https://flagcdn.com/w20/' + flagCode + '.png" style="width:20px; height:15px; margin-right:5px;"> ' + option.text + '</span>');
    }

    // Initialize Select2 for country dropdowns with flags
    $('#pickup_country_id, #destination_country_id').select2({
        templateResult: formatCountry,
        templateSelection: formatCountry,
        width: '100%',
        placeholder: "Select Country",
        allowClear: true
    });

    // Initialize Select2 for cities
    $('#pickup_city_id, #destination_city_id').select2({
        width: '100%',
        placeholder: "Select City",
        allowClear: true
    });

    // Load pickup cities dynamically & preselect
    function loadCities(countryId, cityDropdown, selectedCity) {
        if (countryId) {
            $.get('/get-cities/' + countryId, function (data) {
                cityDropdown.empty().append('<option value="">Select City</option>');
                $.each(data, function (_, city) {
                    cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                });
                if (selectedCity) {
                    cityDropdown.val(selectedCity).trigger('change');
                }
            });
        } else {
            cityDropdown.empty().append('<option value="">Select City</option>');
        }
    }

    // On change events
    $('#pickup_country_id').on('change', function () {
        loadCities($(this).val(), $('#pickup_city_id'), null);
    });

    $('#destination_country_id').on('change', function () {
        loadCities($(this).val(), $('#destination_city_id'), null);
    });

    // Preload cities from DB when editing
    loadCities("{{ $shipment->pickup_country_id }}", $('#pickup_city_id'), "{{ $shipment->pickup_city_id }}");
    loadCities("{{ $shipment->destination_country_id }}", $('#destination_city_id'), "{{ $shipment->destination_city_id }}");

    // Date validation - cargo ready date should not be in the past
    $('#cargo_ready_date').change(function() {
        const selectedDate = new Date($(this).val());
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (selectedDate < today) {
            $(this).addClass('is-invalid');
            if ($(this).next('.invalid-feedback').length === 0) {
                $(this).after('<div class="invalid-feedback">Cargo ready date cannot be in the past</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Remove server-side errors on change
    $('.form-control, .form-select').on('input change', function() {
        if ($(this).hasClass('is-invalid') && $(this).val()) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });

    // Remove checkbox group errors when any checkbox is checked
    $('input[name="shipment_type[]"]').on('change', function() {
        if ($('input[name="shipment_type[]"]:checked').length > 0) {
            $('.checkbox-group').removeClass('is-invalid');
            $('.checkbox-group').next('.invalid-feedback').hide();
        }
    });
});
</script>
@endsection

