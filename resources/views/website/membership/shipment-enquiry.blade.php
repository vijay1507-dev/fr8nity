@extends('layouts.website')

@section('title', 'Submit Shipment Enquiry - Fr8nity')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Submit Shipment Enquiry</h1>
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <h2 class="h3 mb-4">Coming Soon</h2>
                    <p class="lead text-muted">Our shipment enquiry system is under development. Soon you'll be able to submit and track your shipment enquiries seamlessly!</p>
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