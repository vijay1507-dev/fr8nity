<footer class="footer_main py-md-5 py-4">
    <div class="container py-md-3">
        <div class="row gy-4">
            <div class="col-12 col-lg-3 mb-3">
                <div class=" text-start  ps-3 ps-md-0 ps-lg-0">
                    <img src="{{asset('images/logo (3).svg')}}" alt="Company Logo" class="mb-3 img-fluid" />
                    <p class="fs-6">
                        Lorem Ipsum is simply dummy text of the printing and typesetting.
                    </p>
                    <div class="d-flex gap-2  justify-content-start ">
                        @if(!empty($siteSettings['social_twitter']))
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" class="footericon"><img src="{{asset('images/twitter (1) 1.svg')}}" alt="Twitter"
                                    class="img-fluid" /></a>
                        @endif
                        @if(!empty($siteSettings['social_facebook']))
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="footericon"><img src="{{asset('images/footerfacebook.svg')}}" alt="Facebook"
                                    class="img-fluid" /></a>
                        @endif
                        @if(!empty($siteSettings['social_instagram']))
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="footericon"><img src="{{asset('images/instagram.svg')}}" alt="Instagram"
                                    class="img-fluid" /></a>
                        @endif
                        @if(!empty($siteSettings['social_linkedin']))
                            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" class="footericon"><img src="{{asset('images/linkedin (1) 1.svg')}}" alt="LinkedIn"
                                    class="img-fluid" /></a>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-9 ">
               <div class="row gy-4 ps-3  ps-md-0  ps-lg-0">

                    <div class="col-12   col-lg-3 mb-3 ">
                        <div class=''>
                            <h5 class="fw-semibold fs-5">Quick Links</h5>
                            <div
                                class='d-flex justify-content-start '>
                                <ul class="list-unstyled mt-3 ">
                                    
                                    <li class="d-flex align-items-center  ">
                                        <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                        <a href="{{ url('/') }}" class="text-decoration-none">Home</a>
                                    </li>
                                      <li class="d-flex align-items-center pt-3">
                                        <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                        <a href="{{ url('/about-us') }}" class="text-decoration-none">About Us</a>
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                       <a href="{{ url('/spotlight/event-pulse') }}" class="text-decoration-none">Event</a>
                                  
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                          <a href="{{ url('contact-us') }}" class="text-decoration-none">Contact Us</a>
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                        <a href="{{ url('#') }}" class="text-decoration-none">Company Directory</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>


                    <div class="col-12 col-lg-3">

                        <h5 class="fw-semibold fs-5 ">Useful Links</h5>
                        <div class='d-flex justify-content-start '>
                            <ul class="list-unstyled mt-3">
                                <li class="d-flex align-items-center">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                    <a href="#" class="text-decoration-none">Cooperation Risk Protection</a>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                    <a href="#" class="text-decoration-none">Inquiry</a>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                    <a href="#" class="text-decoration-none">Tools</a>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                       <a href="#" class="text-decoration-none">Global Partner</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12  col-lg-3">
                        <h5 class="fw-semibold fs-5 ">Services</h5>
                        <div class='d-flex justify-content-start '>

                            <ul class="list-unstyled mt-3">
                                <li class="d-flex align-items-center">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                      <a href="#" class="text-decoration-none">Business Opportunity Matching</a>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" /> -->
                                      <a href="#" class="text-decoration-none">Marketing & Promotion Services</a>
                                </li>
                                <li class="d-flex align-items-center pt-3 ">
                                    <!-- <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2 " /> -->
                                    <a href="#" class="text-decoration-none">Reduce Costs & Boost Efficiency</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12 col-lg-3">
                        <h5 class="fw-semibold fs-5">Contact Us</h5>
                        <ul class="px-0 mt-3">
                            @if(!empty($siteSettings['site_phone']))
                            <li class="d-flex  mb-2">
                                <img src="{{asset('images/footerphn.svg')}}" alt="Phone" class="me-2" />
                                <a href="tel:{{ $siteSettings['site_phone'] }}" class="">{{ $siteSettings['site_phone'] }}</a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['site_email']))
                            <li class="d-flex  pt-3 mb-2">
                                <img src="{{asset('images/footermessage.svg')}}" alt="Email" class="me-2" />
                                <a href="mailto:{{ $siteSettings['site_email'] }}" class="">{{ $siteSettings['site_email'] }}</a>
                            </li>
                            @endif
                            <li class="d-flex  pt-3 mb-2">
                                <img src="{{asset('images/footerlocation.svg')}}" alt="Location" class="me-2 ms-0" />
                              <a href="#" class="">Dummy Address</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class='footer_bottom p-3'>
    <div class='container'>
        <div class='text-center'>
            <p class='m-0 text-white'>Copyright 2025 © Fr8nity. All rights reserved.</p>
        </div>
    </div>
</div>