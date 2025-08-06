@extends('layouts.website')

@section('title', 'Submit Shipment Enquiry - Fr8nity')

@section('content')
<section class="trader_sec">
    <div class="col-12 col-md-8 mx-auto bg-dark p-5 rounded my-5">
       <div class="tittle d-flex justify-content-center align-items-center">
          <div class="pb-3">  <h1 class="mb-4 fw-semibold text-center">Shipment Enquiry form</h1>
           </div>
       </div>

       <form method="POST" action="{{ route('shipment-enquiry.store') }}" enctype="multipart/form-data" id="shipmentEnquiryForm">
        @csrf
           <div class="form-section row g-3">
              <div class="col-md-6">
                   <label class="form-label">Name*</label>
                   <input type="text" class="form-control inputbox @error('name') is-invalid @enderror" 
                          name="name" placeholder="Enter your name" value="{{ old('name') }}">
                   @error('name')
                       <div class="invalid-feedback d-block text-danger">
                           {{ $message }}
                       </div>
                   @enderror
               </div>
               <div class="col-md-6">
                   <label class="form-label">Email ID*</label>
                   <input type="email" class="form-control inputbox @error('email') is-invalid @enderror" 
                          name="email" placeholder="Enter your email" value="{{ old('email') }}">
                   @error('email')
                       <div class="invalid-feedback d-block text-danger">
                           {{ $message }}
                       </div>
                   @enderror
               </div>
               <div class="col-md-6">
                   <label class="form-label">Phone Number*</label>
                   <input type="tel" class="form-control inputbox @error('phone') is-invalid @enderror" 
                          id="phone" name="phone" value="{{ old('phone') }}">
                   @error('phone')
                       <div class="invalid-feedback d-block text-danger">
                           {{ $message }}
                       </div>
                   @enderror
               </div>
               <div class="col-md-6">
                   <label class="form-label">Company Name*</label>
                   <input type="text" class="form-control inputbox @error('company_name') is-invalid @enderror" 
                          name="company_name" placeholder="Enter your company name" value="{{ old('company_name') }}">
                   @error('company_name')
                       <div class="invalid-feedback d-block text-danger">
                           {{ $message }}
                       </div>
                   @enderror
               </div>
               <div class="col-md-6">
                   <label class="form-label">Shipment Type (Choose one or more)</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Import" name="shipment_type[]" value="Import">
                           <label class="form-check-label" for="Import">Import</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Export" name="shipment_type[]" value="Export">
                           <label class="form-check-label" for="Export">Export</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="CrossTrade" name="shipment_type[]" value="CrossTrade">
                           <label class="form-check-label" for="CrossTrade">Cross Trade</label>
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
                   <label class="form-label">Mode of Transport</label>
                   <select class="form-select" name="mode_of_transport">
                        <option value="">Select Mode of Transport</option>
                        <option value="Air">Air</option>
                        <option value="Sea">Sea</option>
                        <option value="Land">Land / Trucking</option>
                        <option value="OOG">OOG/Breakbulk/Project</option>
                    </select>
               </div>
               <h4 class="text-white mb-0 mt-4">Shipment Information</h4>
               <div class="col-md-6">
                   <label class="form-label">Goods Description</label>
                   <input type="text" class="form-control inputbox" name="goods_description" placeholder="Goods Description">
               </div>
                <div class="col-md-6">
                   <label class="form-label">Estimated Volume / Weight</label>
                   <input type="text" class="form-control inputbox" name="estimated_volume" placeholder="Estimated Volume / Weight">
               </div>
                 <div class="col-md-6">
                   <label class="form-label">Cargo Ready Date</label>
                   <div class="date-picker-wrapper">
                    <input type="text" class="form-control @error('cargo_ready_date') is-invalid @enderror"
                        id="cargo_ready_date" name="cargo_ready_date"
                        placeholder="Select Date" value="{{ old('cargo_ready_date') }}">
                    <svg class="calendar-icon" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                </div>
               </div>
               <div class="col-md-6">
                <label class="form-label">Upload Documents</label>
                <input type="file" class="form-control inputbox" name="documents" placeholder="Upload Documents">
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-white">Pickup Country*</label>
                <select class="form-select @error('pickup_country_id') is-invalid @enderror" id="pickup_country" name="pickup_country_id" data-old="{{ old('pickup_country_id') }}">
                    <option value="">Select Country</option>
                </select>
                @error('pickup_country_id')
                    <div class="invalid-feedback d-block text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-white">Pickup City*</label>
                <select class="form-select @error('pickup_city_id') is-invalid @enderror" id="pickup_city" name="pickup_city_id" data-old="{{ old('pickup_city_id') }}">
                    <option value="">Select City</option>
                </select>
                @error('pickup_city_id')
                    <div class="invalid-feedback d-block text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-white">Destination Country*</label>
                <select class="form-select @error('destination_country_id') is-invalid @enderror" id="destination_country" name="destination_country_id" data-old="{{ old('destination_country_id') }}">
                    <option value="">Select Country</option>
                </select>
                @error('destination_country_id')
                    <div class="invalid-feedback d-block text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-white">Destination City*</label>
                <select class="form-select @error('destination_city_id') is-invalid @enderror" id="destination_city" name="destination_city_id" data-old="{{ old('destination_city_id') }}">
                    <option value="">Select City</option>
                </select>
                @error('destination_city_id')
                    <div class="invalid-feedback d-block text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
                 
            <div class="col-md-12">
                <label class="form-label">Any Special Handling or Notes? </label>
                <input type="text" class="form-control inputbox" name="special_notes" placeholder="Any Special Handling or Notes?">
            </div>

            <div class="col-md-12">
                <label class="form-label">Delivery Remark </label>
                <textarea class="form-control inputbox" name="delivery_remark" rows="4" placeholder="Delivery Remark"></textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input checkboxpadding" type="checkbox" id="consent" name="consent" value="1">
                    <label class="form-check-label" for="consent">By submitting this form, you consent to FR8NITY sharing your shipment details with relevant and trusted freight partners within our network for the purpose of quotation and coordination. We do not sell your data or pass it to third parties outside the network.</label>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btnbg fw-semibold mt-4">Submit</button>
            </div>
           </div>
       </form>
   </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="{{asset('js/shipmentEnquiry.js?v=' . rand(1, 1000000))}}"></script>
@endsection 