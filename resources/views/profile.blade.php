@extends('layouts.app')

@section('title', 'Profile')

@section('content')

 <div class="container py-4">

    <!-- Header -->
    <div class=" d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-4">
      <div>
        <h2 class="mb-1">My Profile</h2>
        <p class="fs-5 mb-0">A list of all patients in your clinic with their details.</p>
      </div>
      <a class="btn btnbg mt-3 mt-sm-0" href="https://fr8nity.sistagging.com/edit-profile">Edit Profile</a>
    </div>

    <!-- Profile Photo Card -->
    <div class="blacklight p-4 rounded mb-3">
      <h3 class="mb-4">Profile Photo</h3>
      <div class="d-flex flex-column flex-sm-row align-items-center">
        <!-- Profile Image Placeholder -->
   <div id="profilePreview" class="doctor_profile d-flex justify-content-center align-items-center rounded-circle overflow-hidden mb-3 mb-sm-0"
     style="background-color: brown; width: 120px; height: 120px;">
  <img src="./images/user.png" alt="User Profile" style="width: 100%; height: 100%; object-fit: cover;">
</div>


        <!-- Upload Section -->
        <div class="ms-0 ms-sm-3 text-center text-sm-start">
          <p class="mb-2 fw-semibold fs-5">{{ auth()->user()->name }}</p>
          <p class="d-block">Designing</p>
        </div>
      </div>
    </div>

    <!-- Personal Details -->
    <div class="mt-0 blacklight p-4 rounded  row mx-0">
      <h3 class="pb-4">Personal Details</h3>
      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Email*</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">WhatsApp/Phone</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Company Name</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Company Telephone</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Company Address</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Country*</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">City*</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Region</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Incorporation Date</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Tax ID*</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Website / LinkedIn</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Referred By</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Specializations</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">What are you looking to gain?</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <h5 class="">Are you currently a member of any other network?</h5>
        <p class="">abdgsjfyikstik</p>
      </div>

    </div>
  </div>

@endsection 