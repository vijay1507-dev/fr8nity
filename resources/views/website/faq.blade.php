@extends('layouts.website')

@section('title', 'Membership FAQ - Fr8nity')

@section('content')

    <section>
        <div class="container blackbg">
            <div class="row">
                <!-- Left Column -->
                <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
                    <div>
                        <h1 class="fw-bold size text_image">
                            Fr8nity Membership FAQ
                        </h1>
                        <p class="fs-6 ">Fr8nity is an exclusive global freight forwarding network connecting trusted
                            logistics professionals. Discover our private membership tiers, curated referrals, and elite
                            networking opportunities. Apply to join our select community today.</p>

                    </div>
                </div>

                <!-- Right Column (Video) -->
                <div class="col-12 col-md-6 mb-md-3 ">
                    <video src="{{asset('images/bannervideo.mp4')}}" autoplay muted loop playsinline class="w-100"></video>
                </div>
            </div>
        </div>
    </section>
    <div class="container py-5 blackbg">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-11">
                <div class="accordion" id="faqAccordion">

                    <!-- Accordion Item 1 -->
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne1">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between border-0 align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="false"
                                aria-controls="collapseOne1">
                                <h6 class="fs-5 text-white pt-3">What is Fr8nity?</h6>
                                <div class="icon fw-semibold fs-5 pt-2">
                                    <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne1" class="accordion-collapse collapse" aria-labelledby="headingOne1"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0 ">
                                <p class="faq-dis mb-0"> Fr8nity is a private, invitation-driven network for freight forwarders
                                    and logistics professionals. We connect vetted, credible businesses worldwide - enabling meaningful
                                    introductions, strategic partnerships, and trusted collaboration.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 2 -->
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne2">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false"
                                aria-controls="collapseOne2">
                                <h6 class="fs-5 text-white pt-3"> Who can join Fr8nity?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne2"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 pt-0 px-3">
                                <p class="faq-dis mb-1"> Membership is reserved for:</p>
                                <ul class="ps-3 mb-0">
                                    <li class="faq-dis mb-1"> - Independent freight forwarders</li>
                                    <li class="faq-dis mb-1"> - Logistics companies</li>
                                    <li class="faq-dis mb-1"> - NVOCCs & customs brokers</li>
                                    <li class="faq-dis mb-1"> - Specialist trade service providers</li>
                                    <li class="faq-dis mb-1"> - Select buyers & sellers of goods (via our Trade Member
                                        category)</li>
                                </ul>
                                <p class="faq-dis mb-0"> Every applicant undergoes a thorough review process before joining.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 3 -->
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne3">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="false"
                                aria-controls="collapseOne3">

                                <h6 class="fs-5 text-white pt-3"> What are the membership tiers?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne3" class="accordion-collapse collapse" aria-labelledby="headingOne3"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class="faq-dis mb-1"> We offer three core tiers plus an invite-only Founders Circle:</p>
                                <p class="faq-dis mb-1"><strong>Explorer - </strong>Your entry into a trusted circle of freight
                                    professionals.</p>
                                <p class="faq-dis mb-1"><strong>Elevate - </strong>Increased visibility and stronger referral
                                    access.</p>
                                <p class="faq-dis mb-1"><strong>Summit - </strong>Maximum influence and priority introductions.
                                </p>
                                <p class="faq-dis mb-1"><strong>Founder - </strong>By invitation only for industry leaders
                                    shaping the network..</p>
                                <p class="faq-dis mb-0"><strong>Explorer -</strong> Your entry into a trusted circle of freight
                                    professionals.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 4 -->
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne4">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="false"
                                aria-controls="collapseOne4">

                                <h6 class="fs-5 text-white pt-3">How much does membership cost?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne4" class="accordion-collapse collapse" aria-labelledby="headingOne4"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0  px-3 pt-0">
                                <p class="faq-dis mb-0">We do not publish fees online. Pricing is provided only during the
                                    application process to qualified candidates.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 5 -->
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne5">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="false"
                                aria-controls="collapseOne5">
                                <h6 class="fs-5 text-white pt-3">How do I apply for membership?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                            </h2>
                            <div id="collapseOne5" class="accordion-collapse collapse" aria-labelledby="headingOne5"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body border-0 px-3 pt-0">
                                    <ul class="ps-0 mb-0">
                                        <li class="faq-dis mb-1"> 1. Complete our membership application</li>
                                        <li class="faq-dis mb-1">2. Submit your company profile and references</li>
                                        <li class="faq-dis mb-1">3. Undergo our vetting and verification process</li>
                                        <li class="faq-dis mb-0"> 4. Receive your personalised membership invitation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne6">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6" aria-expanded="false"
                                aria-controls="collapseOne6">

                                <h6 class="fs-5 text-white pt-3">How selective is Fr8nity?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne6" class="accordion-collapse collapse" aria-labelledby="headingOne6"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class="faq-dis mb-0">We prioritise quality over quantity. Members are chosen for their
                                    credibility, ethical business practices, and track record - ensuring every introduction
                                    is genuine and dependable.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne7">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne7" aria-expanded="false"
                                aria-controls="collapseOne7">

                                <h6 class="fs-5 text-white pt-3">Can I join from any country?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne7" class="accordion-collapse collapse" aria-labelledby="headingOne7"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class="faq-dis mb-0">Yes. Fr8nity is a global network with members across key freight hubs
                                    worldwide. We maintain balanced representation to prevent oversaturation in any market..
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne8">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne8" aria-expanded="false"
                                aria-controls="collapseOne8">

                                <h6 class="fs-5 text-white pt-3">What benefits do members enjoy?</h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne8" class="accordion-collapse collapse" aria-labelledby="headingOne8"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <ul class="ps-0 mb-0">
                                    <li class="faq-dis mb-1"> Access to verified global partnerships</li>
                                    <li class="faq-dis mb-1">Qualified referral introductions</li>
                                    <li class="faq-dis mb-1">Private networking events and selective in-person meetups</li>
                                    <li class="faq-dis mb-1">Recognition through our RisePoints system</li>
                                    <li class="faq-dis mb-0">Inclusion in a curated membership circle</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne9">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne9" aria-expanded="false"
                                aria-controls="collapseOne9">

                                <h6 class="fs-5 text-white pt-3">How do referrals work?
                                </h6>
                                <div class="icon fw-semibold fs-5 pt-3">    <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg></div>
                            </div>
                        </div>
                        <div id="collapseOne9" class="accordion-collapse collapse" aria-labelledby="headingOne9"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class="faq-dis mb-0">Fr8nity facilitates qualified introductions between members for
                                    specific trade lanes, industries, or specialties. Referrals are made with discretion and
                                    precision, ensuring the right partner for the right opportunity</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne10">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne10"
                                aria-expanded="false" aria-controls="collapseOne9">

                                <h6 class="fs-5 text-white pt-3">What is the Trade Member category?
                                </h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne10" class="accordion-collapse collapse" aria-labelledby="headingOne10"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class="faq-dis mb-0">
                                    Trade Members are buyers or sellers of goods seeking access to vetted freight
                                    forwarders. They enjoy limited referral privileges and participation in select
                                    networking opportunities.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne11">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne11"
                                aria-expanded="false" aria-controls="collapseOne11">

                                <h6 class="fs-5 text-white pt-3"> Can I upgrade my membership?
                                </h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne11" class="accordion-collapse collapse" aria-labelledby="headingOne11"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0 pt-0">
                                <p class="faq-dis mb-0">Yes. Members may request an upgrade at any time, subject to review and
                                    network needs.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne12">
                            <div class="py-2 collapsed faq-title d-flex justify-content-between align-items-center w-100 toggle-icon"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne12"
                                aria-expanded="false" aria-controls="collapseOne9">

                                <h6 class="fs-5 text-white pt-3">Why choose Fr8nity?
                                </h6>
                                <div class="icon fw-semibold fs-5 pt-3">
                                        <svg
                                     width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne12" class="accordion-collapse collapse" aria-labelledby="headingOne12"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body border-0 px-3 pt-0">
                                <p class=" faq-dis mb-0">Fr8nity is curated, relationship-driven, and built for long-term trust.
                                    Our philosophy is simple: When one thrives, we all rise.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const toggleItems = document.querySelectorAll('.toggle-icon');

    toggleItems.forEach(toggleHeader => {
        const targetId = toggleHeader.getAttribute('data-bs-target');
        const collapseEl = document.querySelector(targetId);
        const iconEl = toggleHeader.querySelector('.icon');

        const showIcon = `
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                 width="20px" height="20px" viewBox="0 0 32 32" xml:space="preserve" fill="#fff" stroke="#fff">
                <rect x="8" y="15" width="16" height="2" fill="#ffffff"></rect>
            </svg>`;

     
        const hideIcon = `
            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>`;


        collapseEl.addEventListener('show.bs.collapse', function () {
            iconEl.innerHTML = showIcon;
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            iconEl.innerHTML = hideIcon;
        });
    });
});
   </script>
@endpush