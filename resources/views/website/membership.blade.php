@extends('layouts.website')

@section('title', 'Membership')

@section('content')
    <section>
        <div class="container blackbg">
            <div class="row">
                <!-- Left Column -->
                <div class="col-12 col-md-6 mb-4 d-flex flex-column justify-content-center align-items-start">
                    <h1 class="fw-bold size text_image mb-4">Are You Apply For</h1>
                    <div class="Membership_modal">
                        <a href="{{route('register')}}">Freight Network</a>
                        <a href="{{route('membership.trade-member')}}">Trade Network</a>
                    </div>
                </div>

                <!-- Right Column (Video) -->
                <div class="col-12 col-md-6 mb-md-3 r">
                    <video src="{{ asset('images/bannervideo.mp4') }}" autoplay muted loop playsinline class="w-100"></video>
                </div>
            </div>
        </div>
    </section>
@endsection
