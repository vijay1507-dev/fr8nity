@extends('layouts.website')

@section('title', 'Thank You - Fr8nity')

@section('content')
<section class="trader_sec">
    <div class="col-12 col-md-8 mx-auto text-center bg-dark p-5 rounded my-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
        </div>
        <h1 class="mb-4 fw-semibold">Thank You!</h1>
        <p class="mb-4">
            @if(session('message'))
                {{ session('message') }}
            @else
                Your request has been submitted successfully. Our team will review your request and get back to you shortly.
            @endif
        </p>
        <div class="mt-4">
            <a href="/" class="btn btnbg fw-semibold">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        </div>
    </div>
</section>
@endsection