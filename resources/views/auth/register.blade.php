<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .progress-bar-container {
            padding: 0 15px;
        }
        .progress {
            background-color: #2d2d2d;
        }
        .progress-bar {
            background-color: #0d6efd;
            transition: width 0.3s ease;
        }
        .progress-step {
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        .progress-step.active {
            opacity: 1;
        }
        .country-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .country-flag {
            width: 21px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
        }
        .selected-country {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Common Select2 Styles for all dropdowns */
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            height: 38px;
            padding: 0.375rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            padding-left: 0;
            color: #212529;
        }
        .select2-container--default .select2-results__option {
            padding: 8px 12px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 8px;
            border-radius: 4px;
        }
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0d6efd;
        }
        /* Dark theme for the form */
        .dark-form .select2-container--default .select2-selection--single {
            background-color: #2d2d2d;
            border-color: #444;
        }
        .dark-form .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }
        .dark-form .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #aaa;
        }

        /* Select2 Light Theme Styles */
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem;
            height: 38px;
            padding: 0.375rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            padding-left: 0;
            color: #212529 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        .select2-dropdown {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            color: #212529 !important;
            padding: 8px;
            border-radius: 4px;
        }
        .select2-container--default .select2-results__option {
            padding: 8px 12px;
            color: #212529 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e9ecef !important;
            color: #212529 !important;
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        /* Country option with flag styles */
        .country-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 0;
        }
        .country-flag {
            width: 24px;
            height: 18px;
            object-fit: cover;
            border-radius: 2px;
        }
        /* Search box enhancements */
        .select2-search--dropdown {
            padding: 8px;
        }
        /* Dropdown positioning and animation */
        .select2-container--open .select2-dropdown {
            margin-top: 4px;
            animation: selectDropdown 0.2s ease-out;
        }
        @keyframes selectDropdown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Flatpickr Custom Styles */
        .flatpickr-calendar {
            background: #fff;
            border-radius: 0.375rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #ced4da;
        }
        .flatpickr-day.selected {
            background: #0d6efd;
            border-color: #0d6efd;
        }
        .flatpickr-day.today {
            border-color: #0d6efd;
        }
        .flatpickr-day:hover {
            background: #e9ecef;
        }
        .flatpickr-months .flatpickr-month {
            background: #f8f9fa;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: #f8f9fa;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
            background: #e9ecef;
        }
        .flatpickr-input {
            background-color: #fff !important;
        }
        /* Custom calendar icon */
        .date-picker-wrapper {
            position: relative;
        }
        .date-picker-wrapper .calendar-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }
        /* Select2 clear button styles */
        .select2-selection__clear {
            color: #999 !important;
            margin-right: 5px !important;
            padding: 0 5px !important;
            font-weight: bold !important;
        }
        .select2-selection__clear:hover {
            color: #666 !important;
        }

        /* Select2 container and input styles */
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 0.375rem 35px 0.375rem 0.75rem !important;
        }
        
        /* Select2 clear button (cross icon) styles */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            font-size: 18px;
            line-height: 1;
            color: #6c757d !important;
            margin-right: 25px !important;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 !important;
            height: auto !important;
            background: transparent !important;
            border: none !important;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #dc3545 !important;
        }

        /* Arrow positioning */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            right: 8px !important;
            height: 100% !important;
        }

        /* Selected text positioning */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
            padding-right: 25px !important;
        }

        /* Country option specific styles */
        .country-option {
            padding: 4px 0;
        }

        /* Ensure proper spacing for flag images */
        .country-flag {
            margin-right: 8px;
        }

        /* Dropdown styling */
        .select2-dropdown {
            border-radius: 4px !important;
            margin-top: 1px !important;
        }

        .select2-results__option {
            padding: 8px 12px !important;
        }

        /* Search box styling */
        .select2-search--dropdown {
            padding: 8px !important;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 6px 8px !important;
            border-radius: 4px !important;
        }
    </style>
</head>

<body style="overflow: hidden;">
    <div class="wrapper userlogin p-0 bg-black">
        <main class="content">
            <div class="row justify-content-center mx-0 bg-white overflow-hidden">
                <div class="col-12 col-md-4 left-img vh-100 d-flex justify-content-center p-4"
                    style="background: url(./images/admin-login.webp) no-repeat center / cover">
                    <div class="left-side">
                        <img class="mb-3" src="{{asset('images/logo.svg')}}" alt="Logo" width="auto" height="78">
                    </div>
                </div>
                <div class="col-md-8 col-12 bg-black">
                    <div class="custom-card m-0 p-md-4">
                        <form role="form">
                            <div class="row setup-content mx-0" id="step-1">
                                <div class="col-md-12 px-0">
                                    <h3 class="text-white text-center mb-3">Become a Member</h3>
                                    <div class="progress-bar-container mb-4">
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <span class="progress-step active text-white">Step 1</span>
                                            <span class="progress-step text-white">Step 2</span>
                                        </div>
                                    </div>
                                    <div class="inputs-container row bg-dark rounded mt-3">                                       
                                        <div class="row p-3 pb-0 mx-0">
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Name*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Name*">
                                            </div>
                                             <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Designation*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Designation*">
                                            </div>
                                             <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Email*</label>
                                                <input type="email" class="form-control"
                                                    placeholder="Email*">
                                            </div>
                                             <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">WhatsApp/Phone*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="WhatsApp/Phone*">
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Password*</label>
                                                <input type="password" class="form-control"
                                                    placeholder="Password*">
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Confirm Password*</label>
                                                <input type="password" class="form-control"
                                                    placeholder="Confirm Password*">
                                            </div>

                                        </div>
                                        <div class="row p-3 pt-0 mx-0">
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Company Name*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Company Name*">
                                            </div>
                                             <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Country*</label>
                                                <select class="form-select" id="country" name="country" required>
                                                    <option value="">Select Country</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">State*</label>
                                                <select class="form-select" id="state" name="state" required disabled>
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">City*</label>
                                                <select class="form-select" id="city" name="city" required disabled>
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                              <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Region*</label>
                                                <select class="form-select" id="region" name="region" required>
                                                    <option value="">Select Region</option>
                                                </select>
                                            </div>
                                             <div class="mb-3 col-12">
                                                <label class="form-label text-white">Specializations</label>
                                              <div class="d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                                                      <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                                    <label class="form-check-label text-white" for="checkDefault">
                                                        Air
                                                    </label>
                                                    </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked" >
                                                    <label class="form-check-label text-white" for="checkChecked">
                                                        Sea
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="Land" >
                                                    <label class="form-check-label text-white" for="Land">
                                                        Land
                                                    </label>
                                                </div>
                                                 <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="Multimodal" >
                                                    <label class="form-check-label text-white" for="Multimodal">
                                                        Multimodal
                                                    </label>
                                                </div>
                                                 <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="Cargo" >
                                                    <label class="form-check-label text-white" for="Cargo">
                                                        Project Cargo
                                                    </label>
                                                </div>
                                              </div>
                                            </div>
                                             <div class="mb-3 col-12 col-md-4">
                                                <label class="form-label text-white">Incorporation Date*</label>
                                                <div class="date-picker-wrapper">
                                                    <input type="text" class="form-control" id="incorporation_date" name="incorporation_date" placeholder="Select Date" required>
                                                    <svg class="calendar-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                             <div class="mb-3 col-12 col-md-4">
                                                <label class="form-label text-white">Tax ID*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Tax ID*">
                                            </div>
                                             <div class="mb-3 col-12 col-md-4">
                                                <label class="form-label text-white">Website / LinkedIn*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Website / LinkedIn*">
                                            </div>
                                            

                                              <div class="mb-3 col-12">
                                                    <label class="form-label text-white">What are you looking to gain?</label>
                                                    <div class="d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                                                            <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="Sales">
                                                            <label class="form-check-label text-white" for="Sales">
                                                                Sales leads
                                                            </label>
                                                            </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="E-learning/training" >
                                                            <label class="form-check-label text-white" for="E-learning/training">
                                                                E-learning/training
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="Network" >
                                                            <label class="form-check-label text-white" for="Network">
                                                                Network access
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="representation" >
                                                            <label class="form-check-label text-white" for="representation">
                                                                Global representation
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="credibility" >
                                                            <label class="form-check-label text-white" for="credibility">
                                                                Brand credibility
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="Exposure/Marketing" >
                                                            <label class="form-check-label text-white" for="Exposure/Marketing">
                                                                Branding Exposure/Marketing
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="Business" >
                                                            <label class="form-check-label text-white" for="Business">
                                                                Business matching
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="mb-3 col-12">
                                                    <label class="form-label text-white">Are you currently a member of any other network?</label>
                                                    <div class="d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                                                            <div class="form-check mb-0">
                                                            <input class="form-check-input" name="currently" type="radio" value="yes" id="currentlyYes">
                                                            <label class="form-check-label text-white" for="currentlyYes">
                                                                Yes
                                                            </label>
                                                            </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" name="currently" type="radio" value="no" id="currentlyNo" checked>
                                                            <label class="form-check-label text-white" for="currentlyNo">
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-12 col-md-12" id="networkField" style="display:none;">
                                                <label class="form-label text-white">Network Name*</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Network Name*">
                                            </div>
                                        </div>

                                    </div>
                                   
                                    <div class="d-flex justify-content-center mt-4">
                                        <button class="btn btn-primary nextBtn px-5" type="button">Next Step</button>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row setup-content" id="step-3" style="display: none;">
                                <div class="col-md-12 px-0">
                                    <h3 class="text-white text-center mb-3">Choose Your Plan</h3>
                                    <div class="progress-bar-container mb-4">
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <span class="progress-step text-white">Step 1</span>
                                            <span class="progress-step active text-white">Step 2</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                             <div class="Benefit_cards h-100">
                                                <input class="form-check-input" name="membership_tier" type="radio" value="" id="Benefit01">
                                                <label class="h-100" for="Benefit01">
                                                     <div class="bg-dark p-3 rounded h-100">
                                                        <h4 class="text-white pb-2">Explorer's Benefit</h4>
                                                        <ul class="list-group">
                                                            <li class="text-white mb-2">Access to online member directory</li>
                                                            <li class="text-white mb-2">Member dashboard</li>
                                                            <li class="text-white mb-2">Basic listing in logistics partner network</li>
                                                            <li class="text-white">Earn points through participation & business referrals (lower earning rate)</li>
                                                        </ul>
                                                    </div>
                                                </label>
                                                </div>
                                           
                                        </div>
                                         <div class="col-12 col-md-4">
                                             <div class="Benefit_cards h-100">
                                                <input class="form-check-input" name="membership_tier" type="radio" value="" id="Benefit02">
                                                <label class="h-100" for="Benefit02">
                                                     <div class="bg-dark p-3 rounded h-100">
                                                        <h4 class="text-white pb-2">Elevate Benefit</h4>
                                                        <ul class="list-group">
                                                            <li class="text-white mb-2">All Explorer benefits</li>
                                                            <li class="text-white mb-2">Priority access to in-person events an online events</li>
                                                            <li class="text-white mb-2">Featured company spotlight in newsletters and Webpage</li>
                                                            <li class="text-white">Priority business connection and recommendation</li>
                                                              <li class="text-white">Mid-tier points earning (higher multiplier)</li>
                                                        </ul>
                                                    </div>
                                                </label>
                                                </div>
                                           
                                        </div>
                                         <div class="col-12 col-md-4">
                                             <div class="Benefit_cards h-100">
                                                <input class="form-check-input" name="membership_tier" type="radio" value="" id="Benefit03">
                                                <label class="h-100" for="Benefit03">
                                                     <div class="bg-dark p-3 rounded h-100">
                                                        <h4 class="text-white pb-2">Summit Benefit</h4>
                                                        <ul class="list-group">
                                                            <li class="text-white mb-2">All Elevate benefits</li>
                                                            <li class="text-white mb-2">VIP invitation to annual global summit</li>
                                                            <li class="text-white mb-2">Speaking opportunities at network events</li>
                                                            <li class="text-white">Executive networking concierge service</li>
                                                            <li class="text-white">Highest points earning rate</li>
                                                            <li class="text-white">Opportunity to upgrade to Founder Circlee</li>
                                                        </ul>
                                                    </div>
                                                </label>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-3 w-100">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="consentCheckbox" name="consent" required>
                                            <label class="form-check-label text-white" for="consentCheckbox">
                                                I consent to FR8NITY collecting, storing, and using my personal data to process my membership application, provide access to platform features, and contact me with relevant updates. I understand that my information will be handled in accordance with applicable data protection laws, including the PDPA and GDPR.<br>
                                                <span class="d-block mt-2">
                                                    🔗 You can read our full Privacy Policy to understand how we protect your data and your rights.
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 pt-4 gap-3">
                                        <button class="btn btn-secondary px-4 rounded_30 backBtn"
                                            type="button">Back</button>
                                        <button class="btn btn-primary pull-right px-4" type="submit">Submit</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>
        </main>
    </div>
    <script src="{{asset('js/bootstrap.js')}}" defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function () {
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

                allNextBtn.click(function () {
                    var curStep = $(this).closest(".setup-content");
                    var nextStep = curStep.next('.setup-content');

                    if (nextStep.length === 0) {
                        console.error("Next step not found!");
                        return;
                    }

                    var isValid = true; // Temporarily bypass validation for testing
                    if (isValid) {
                        curStep.hide();
                        nextStep.show();
                        updateProgress(2); // Update progress to step 2
                    } else {
                        console.error("Validation failed!");
                    }
                });

                allBackBtn.click(function () {
                    var curStep = $(this).closest(".setup-content");
                    var prevStep = curStep.prev('.setup-content');

                    curStep.hide();
                    prevStep.show();
                    updateProgress(1); // Update progress back to step 1
                });
            });
        });

    </script>


    <script>
        $(document).ready(function () {
            $(".table_head").click(function () {
                $(this).next(".table_tbody").toggle();
            });
        });
    </script>

    <script>
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
    </script>

    <script>
        $(document).ready(function() {
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
                $('#state, #city').val(null).trigger('change').prop('disabled', true);
            });

            // Initialize Select2 for state dropdown
            $('#state').select2({
                theme: 'default',
                placeholder: 'Select State',
                allowClear: true,
                width: '100%'
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

            // Initialize Select2 for region dropdown
            $('#region').select2({
                theme: 'default',
                placeholder: 'Select Region',
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
            $.get('{{ route("get.countries") }}', function(data) {
                let countrySelect = $('#country');
                data.forEach(function(country) {
                    let option = new Option(country.name, country.id);
                    $(option).html(`<div class="country-option">
                        <img src="https://flagcdn.com/w40/${country.code.toLowerCase()}.png" 
                             class="country-flag" 
                             alt="${country.name} flag">
                        <span>${country.name}</span>
                    </div>`);
                    countrySelect.append(option);
                });
            });

            // Handle country change
            $('#country').on('change', function() {
                let countryId = $(this).val();
                let stateSelect = $('#state');
                let citySelect = $('#city');
                
                // Reset and disable state and city
                stateSelect.empty().append('<option value="">Select State</option>').prop('disabled', !countryId);
                citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                
                if(countryId) {
                    // Load states based on selected country
                    $.get('{{ url("get-states") }}/' + countryId, function(data) {
                        data.forEach(function(state) {
                            let option = new Option(state.name, state.id);
                            stateSelect.append(option);
                        });
                    });
                }
            });

            // Handle state change
            $('#state').on('change', function() {
                let stateId = $(this).val();
                let citySelect = $('#city');
                
                // Reset and disable city
                citySelect.empty().append('<option value="">Select City</option>').prop('disabled', !stateId);
                
                if(stateId) {
                    // Load cities based on selected state
                    $.get('{{ url("get-cities") }}/' + stateId, function(data) {
                        data.forEach(function(city) {
                            let option = new Option(city.name, city.id);
                            citySelect.append(option);
                        });
                    });
                }
            });

            // Load regions on page load
            $.get('{{ route("get.regions") }}', function(data) {
                let regionSelect = $('#region');
                data.forEach(function(region) {
                    let option = new Option(region.name, region.id);
                    regionSelect.append(option);
                });
            });
        });
    </script>

    <script>
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
    </script>

</body>

</html>