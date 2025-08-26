@extends('layouts.website')

@section('title', 'Partner Showcase - Spotlight - Fr8nity')

@section('content')
<section class="inner_mamber" style="background: url({{ asset('images/mamber_inner.webp') }}) no-repeat center / cover;">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Partner Showcase</h1>
                <p class="lead">Discover our valued partners and their contributions to the freight & logistics industry</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center p-5">
                        <h2 class="mb-4">Coming Soon</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h4 class="text-warning">Partner Categories</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">Freight Forwarders</li>
                                        <li class="mb-2">Logistics Providers</li>
                                        <li class="mb-2">Technology Partners</li>
                                        <li class="mb-2">Service Providers</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h4 class="text-warning">Showcase Features</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">Company Profiles</li>
                                        <li class="mb-2">Success Stories</li>
                                        <li class="mb-2">Partnership Benefits</li>
                                        <li class="mb-2">Contact Information</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4">We are currently preparing to showcase our amazing partners who contribute to the success of the freight industry. Stay tuned for exciting partner profiles and success stories!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
