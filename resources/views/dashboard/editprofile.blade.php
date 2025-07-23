@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')

  <div class="container py-4">
      <!-- Header -->
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h3 class="mb-2">Edit Profile</h3>
          <p class="font-18">A list of all patients in your clinic with their details.</p>
        </div>
      </div>

      <form id="editProfileForm">
        <!-- Profile Photo -->
        <div class="mb-3 p-4 rounded blacklight">
          <h3 class="mb-4">Profile Photo</h3>
          <div class="d-flex flex-column flex-sm-row align-items-center">
            <div id="profilePreview" class="doctor_profile img-fluid bg-skyblue d-flex justify-content-center align-items-center rounded-circle imgframe mb-3 mb-sm-0" style="width: 120px; height: 120px; font-size: 2rem; color: white; background-color: aquamarine;">
              +
            </div>

            <div class="ms-0 ms-sm-3 text-center text-sm-start">
              <div>
                <label for="uploadPhoto" class="bg-skyblue mb-2 p-3 d-inline-block" style="cursor: pointer;">Upload Photo</label>
                <input type="file" id="uploadPhoto" accept="image/png, image/jpeg, image/gif" hidden />
              </div>
              <div>
                <span class="text-sm">Upload a profile photo. JPG, PNG or GIF. Max 2MB.</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Personal Information -->
        <div class="p-4 rounded blacklight">
          <h3 class="mb-4">Personal Information</h3>
          <div class="row">
            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="name">Name*</label>
              <input type="text" id="name" name="name" class="form-control mb-3 rounded-30" placeholder="Name" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="designation">Designation*</label>
              <input type="text" id="designation" name="designation" class="form-control mb-3 rounded-30" placeholder="Designation" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="email">Email*</label>
              <input type="email" id="email" name="email" class="form-control mb-3 rounded-30" placeholder="Email" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="phone">WhatsApp/Phone*</label>
              <input type="text" id="phone" name="phone" class="form-control mb-3 rounded-30" placeholder="WhatsApp/Phone" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="companyName">Company Name*</label>
              <input type="text" id="companyName" name="company_name" class="form-control mb-3 rounded-30" placeholder="Company Name" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="companyTelephone">Company Telephone*</label>
              <input type="text" id="companyTelephone" name="company_telephone" class="form-control mb-3 rounded-30" placeholder="Company Telephone" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="companyAddress">Company Address*</label>
              <input type="text" id="companyAddress" name="company_address" class="form-control mb-3 rounded-30" placeholder="Company Address" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="country">Country*</label>
              <select class="form-control mb-3 rounded-30" id="country" name="country" required>
                <option value="">Select</option>
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
              </select>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="city">City*</label>
              <select class="form-control mb-3 rounded-30" id="city" name="city" required>
                <option value="">Select</option>
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
              </select>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="region">Region*</label>
              <select class="form-control mb-3 rounded-30" id="region" name="region" required>
                <option value="">Select</option>
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
              </select>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="incorporationDate">Incorporation Date*</label>
              <input type="date" class="form-control mb-3 rounded-30" id="incorporationDate" name="incorporation_date" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="taxId">Tax ID*</label>
              <input type="text" class="form-control mb-3 rounded-30" id="taxId" name="tax_id" placeholder="Tax ID" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="website ">Website / LinkedIn*</label>
              <input type="text" class="form-control mb-3 rounded-30" id="website" name="website" placeholder="Website / LinkedIn" required>
            </div>

            <div class="col-12 col-md-4 col-sm-6">
              <label class="form-label" for="referredBy">Referred by*</label>
              <input type="text" class="form-control mb-3 rounded-30" id="referredBy" name="referred_by" placeholder="Referred by" required>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Specializations</label>
              <div class="d-flex gap-3 flex-wrap p-2 rounded">
                <div class="form-check"><input class="form-check-input" type="checkbox" id="specAir" name="specializations[]" value="Air"><label class="form-check-label" for="specAir">Air</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="specSea" name="specializations[]" value="Sea"><label class="form-check-label" for="specSea">Sea</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="specLand" name="specializations[]" value="Land"><label class="form-check-label" for="specLand">Land</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="specMultimodal" name="specializations[]" value="Multimodal"><label class="form-check-label" for="specMultimodal">Multimodal</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="specCargo" name="specializations[]" value="Project Cargo"><label class="form-check-label" for="specCargo">Project Cargo</label></div>
              </div>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">What are you looking to gain?*</label>
              <div class="d-flex gap-3 flex-wrap p-2 rounded">
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainSales" name="goals[]" value="Sales leads"><label class="form-check-label" for="gainSales">Sales leads</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainTraining" name="goals[]" value="E-learning/training"><label class="form-check-label" for="gainTraining">E-learning/training</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainAccess" name="goals[]" value="Network access"><label class="form-check-label" for="gainAccess">Network access</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainGlobal" name="goals[]" value="Global representation"><label class="form-check-label" for="gainGlobal">Global representation</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainCredibility" name="goals[]" value="Brand credibility"><label class="form-check-label" for="gainCredibility">Brand credibility</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainMarketing" name="goals[]" value="Branding Exposure/Marketing"><label class="form-check-label" for="gainMarketing">Branding Exposure/Marketing</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="gainMatching" name="goals[]" value="Business matching"><label class="form-check-label" for="gainMatching">Business matching</label></div>
              </div>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Are you currently a member of any other network?</label>
              <div class="d-flex gap-3 flex-wrap p-2 rounded">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="network_member" id="networkYes" value="yes">
                  <label class="form-check-label" for="networkYes">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="network_member" id="networkNo" value="no" checked>
                  <label class="form-check-label" for="networkNo">No</label>
                </div>
              </div>
            </div>

            <div class="mb-3 col-12" id="networkNameField" style="display: none;">
              <label class="form-label" for="networkName">Network Name*</label>
              <input type="text" class="form-control" id="networkName" name="network_name" placeholder="Network Name">
            </div>

            <div class="d-flex justify-content-center align-items-center mt-4">
              <button type="submit" class="btn btnbg">Update <i class="fas fa-check ms-2"></i></button>
            </div>

          </div>
        </div>
      </form>
    </div>
@endsection 