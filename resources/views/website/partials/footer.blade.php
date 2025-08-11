<footer class="footer_main py-md-5 py-4">
    <div class="container py-md-3">
        <div class="row gy-4">
            <div class="col-12 col-md-3 mb-3">
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


            <div class="col-12 col-md-9 ">
               <div class="row gy-4 ps-3  ps-md-0  ps-lg-0">

                    <div class="col-12 col-sm-6 col-md-3 mb-3 ">
                        <div class=''>
                            <h5 class="fw-semibold fs-5">Quick Links</h5>
                            <div
                                class='d-flex justify-content-start '>
                                <ul class="list-unstyled mt-3 ">
                                    <li class="d-flex align-items-center  ">
                                        <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                        <Link to="/about" class="text-decoration-none">About Us</Link>
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                        <Link to="/events/calendar" class="text-decoration-none">Event</Link>
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                        <Link to="/membership" class="text-decoration-none">Membership</Link>
                                    </li>
                                    <li class="d-flex align-items-center pt-3">
                                        <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                        <Link to="/directory" class="text-decoration-none">Company Directory</Link>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>


                    <div class="col-12 col-sm-6 col-md-3">

                        <h5 class="fw-semibold fs-5 ">Useful Links</h5>
                        <div class='d-flex justify-content-start '>
                            <ul class="list-unstyled mt-3">
                                <li class="d-flex align-items-center">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Cooperation Risk Protection</Link>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Inquiry</Link>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Tools</Link>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Global Partner</Link>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12 col-sm-6 col-md-3">
                        <h5 class="fw-semibold fs-5 ">Services</h5>
                        <div class='d-flex justify-content-start '>

                            <ul class="list-unstyled mt-3">
                                <li class="d-flex align-items-center">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Business Opportunity Matching</Link>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Marketing & Promotion Services</Link>
                                </li>
                                <li class="d-flex align-items-center pt-3">
                                    <img src="{{asset('images/Vector (1).png')}}" alt="" class="me-2" />
                                    <Link to="#" class="text-decoration-none">Reduce Costs & Boost Efficiency</Link>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12 col-sm-6 col-md-3">
                        <h5 class="fw-semibold fs-5">Contact Us</h5>
                        <ul class="list-unstyled mt-3">
                            @if(!empty($siteSettings['site_phone']))
                            <li class="d-flex align-items-center mb-2">
                                <img src="{{asset('images/footerphn.svg')}}" alt="Phone" class="me-2" />
                                <a href="tel:{{ $siteSettings['site_phone'] }}" class="text-decoration-none text-white">{{ $siteSettings['site_phone'] }}</a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['site_email']))
                            <li class="d-flex align-items-center pt-3 mb-2">
                                <img src="{{asset('images/footermessage.svg')}}" alt="Email" class="me-2" />
                                <a href="mailto:{{ $siteSettings['site_email'] }}" class="text-decoration-none text-white">{{ $siteSettings['site_email'] }}</a>
                            </li>
                            @endif
                            <li class="d-flex align-items-start pt-3 mb-2">
                                <img src="{{asset('images/footerlocation.svg')}}" alt="Location" class="me-2" />
                                <span>Dummy Address</span>
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