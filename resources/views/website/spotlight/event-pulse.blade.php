@extends('layouts.website')

@section('title', 'Event Pulse - Spotlight - Fr8nity')

@section('content')
<section class="inner_mamber" style="background: url({{ asset('images/mamber_inner.webp') }}) no-repeat center / cover;">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Event Pulse</h1>
                <p class="lead">Stay updated with the latest events and activities in the freight & logistics industry</p>
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
                                    <h4 class="text-warning">Upcoming Events</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">Industry Conferences</li>
                                        <li class="mb-2">Networking Events</li>
                                        <li class="mb-2">Training Workshops</li>
                                        <li class="mb-2">Trade Shows</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h4 class="text-warning">Event Highlights</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">Speaker Spotlights</li>
                                        <li class="mb-2">Event Recaps</li>
                                        <li class="mb-2">Photo Galleries</li>
                                        <li class="mb-2">Registration Links</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4">We are currently curating exciting event content to keep you informed about the latest happenings in the freight industry. Stay tuned for updates!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
