@extends('layouts.website')

@section('title', 'Membership FAQ - Fr8nity')

@section('content')
<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 100%), url('{{ asset('images/headtop_bg.jpg') }}') no-repeat center/cover;">
    <div class="container">
        <div class="row justify-content-center text-center py-4">
            <div class="col-md-8">
                <h1 class="display-3 mb-3">Membership FAQ</h1>
                <div class="d-flex justify-content-center">
                    <div class="underline">
                        <div class="move delay-0"></div>
                        <div class="move delay-1"></div>
                    </div>
                </div>
                <p class="lead mt-3 textcolor">Find answers to commonly asked questions about Fr8nity membership</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="h4 mb-4 text-center">Membership FAQ Coming Soon</h2>
                            
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item bg-dark">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            What are the benefits of Fr8nity membership?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Our membership benefits package is currently being finalized. Members will enjoy exclusive access to industry resources, networking opportunities, market insights, and professional development tools.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item bg-dark">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            How does the point system work?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Our point system will reward active participation in the Fr8nity community. Details about point earning and redemption will be announced soon.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item bg-dark">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            What types of membership tiers are available?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            We will offer different membership tiers tailored to various professional needs and engagement levels. Full details will be available upon launch.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-5">
                                <p class="lead text-muted">
                                    We are compiling a comprehensive FAQ section to address all your questions about Fr8nity membership. 
                                    Check back soon for detailed information.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 