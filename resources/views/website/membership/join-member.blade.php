@extends('layouts.website')

@section('title', 'Join as Member - Fr8nity')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Join as Member</h1>
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <h2 class="h3 mb-4">Coming Soon</h2>
                    <p class="lead text-muted">We're currently working on making our membership process even better. Stay tuned for an enhanced joining experience!</p>
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 