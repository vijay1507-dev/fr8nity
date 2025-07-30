@extends('layouts.website')

@section('title', 'Events - Fr8nity')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Upcoming Events</h1>
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <img src="{{ asset('images/coming-soon.svg') }}" alt="Coming Soon" class="img-fluid mb-4" style="max-width: 200px;">
                    </div>
                    <h2 class="h4 mb-3">Stay Tuned for Exciting Events!</h2>
                    <p class="lead text-muted">
                        We are currently organizing a series of industry-leading events and networking opportunities. 
                        Our events calendar is being carefully curated to bring you the most valuable experiences in the freight and logistics industry.
                    </p>
                    <p class="mb-0">
                        Check back soon for updates on upcoming conferences, workshops, and networking events. 
                        Subscribe to our newsletter to be the first to know when new events are announced.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 