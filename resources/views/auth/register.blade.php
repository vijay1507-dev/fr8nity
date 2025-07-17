<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
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
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>select Country</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                              <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">City*</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>select City</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                              <div class="mb-3 col-12 col-md-6">
                                                <label class="form-label text-white">Region*</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>select region</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
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
                                                <input type="date" class="form-control"
                                                    placeholder="Incorporation Date*">
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
                                                    <label class="form-label text-white">Freight Specializations</label>
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
                                                            <input class="form-check-input" name="currently" type="radio" value="no" id="currentlyNo" selected>
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
                                    <h3 class="text-white text-center mb-3">Membership Tier Benefit</h3>
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

                allWells.hide(); // Hide all steps initially
                $('#step-1').show(); // Show the first step

                allNextBtn.click(function () {
                    var curStep = $(this).closest(".setup-content");
                    var nextStep = curStep.next('.setup-content');

                    console.log("Current step: ", curStep.attr('id'));
                    console.log("Next step: ", nextStep.attr('id'));

                    if (nextStep.length === 0) {
                        console.error("Next step not found!");
                        return;
                    }

                    var isValid = true; // Temporarily bypass validation for testing
                    if (isValid) {
                        curStep.hide();
                        nextStep.show();
                    } else {
                        console.error("Validation failed!");
                    }
                });

                allBackBtn.click(function () {
                    var curStep = $(this).closest(".setup-content");
                    var prevStep = curStep.prev('.setup-content');

                    console.log("Current step: ", curStep.attr('id'));
                    console.log("Previous step: ", prevStep.attr('id'));

                    curStep.hide();
                    prevStep.show();
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

</body>

</html>