@extends('layouts.website')

@section('title', 'Join as Member - Fr8nity')

@section('content')
<section class="trader_sec">
    <div class="col-12 col-md-8 mx-auto bg-dark p-5 rounded my-5">
       <div class="tittle d-flex justify-content-center align-items-center">
          <div class="pb-3">  <h1 class="mb-4 fw-semibold text-center">Looking for a Trusted <br>Freight Partner?</h1>
           <div class="col-md-10 mx-auto text-center">
                <p>At FR8NITY, we believe in building a trusted ecosystem where quality trade meets seamless logistics.</p>
           <p>As a Trade Member, your business will be registered in our exclusive database — complimentary and commitment-free. When vetted buyer enquiries arise, you may be among the first we recommend. This isn’t just a listing — it’s a gateway to better business. Join FR8NITY and be part of a network where every connection counts.</p>
           </div>
           </div>

       </div>

       <form method="POST" action="{{ route('join-member.post') }}" id="joinMemberForm">
        @csrf
           <div class="form-section row g-3">
               <div class="col-md-6">
                   <label class="form-label">Company Name</label>
                   <input type="text" class="form-control inputbox @error('company_name') is-invalid @enderror" placeholder="Company Name*" name="company_name" value="{{ old('company_name') }}">
                   @error('company_name')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>
               <div class="col-md-6">
                   <label class="form-label">Product/Industry Category</label>
                   <input type="text" class="form-control inputbox @error('product_industry_category') is-invalid @enderror" placeholder="Product/Industry Category*" name="product_industry_category" value="{{ old('product_industry_category') }}">
                   @error('product_industry_category')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-md-6">
                   <label class="form-label">Shipping Frequency</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Daily" name="shipping_frequency[]" value="Daily" {{ (is_array(old('shipping_frequency')) && in_array('Daily', old('shipping_frequency'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Daily">Daily</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Weekly" name="shipping_frequency[]" value="Weekly" {{ (is_array(old('shipping_frequency')) && in_array('Weekly', old('shipping_frequency'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Weekly">Weekly</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Monthly" name="shipping_frequency[]" value="Monthly" {{ (is_array(old('shipping_frequency')) && in_array('Monthly', old('shipping_frequency'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Monthly">Monthly</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="hoc" name="shipping_frequency[]" value="Ad-hoc" {{ (is_array(old('shipping_frequency')) && in_array('Ad-hoc', old('shipping_frequency'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="hoc">Ad-hoc</label>
                       </div>
                   </div>
                   @error('shipping_frequency')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-md-6">
                   <label class="form-label">Mode of shipment</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap ">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkAir" name="mode_of_shipment[]" value="Air" {{ (is_array(old('mode_of_shipment')) && in_array('Air', old('mode_of_shipment'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="checkAir">Air</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkSea" name="mode_of_shipment[]" value="Sea" {{ (is_array(old('mode_of_shipment')) && in_array('Sea', old('mode_of_shipment'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="checkSea">Sea</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkLand" name="mode_of_shipment[]" value="Land" {{ (is_array(old('mode_of_shipment')) && in_array('Land', old('mode_of_shipment'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="checkLand">Land</label>
                       </div>
                   </div>
                   @error('mode_of_shipment')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>
               <div class="mb-3 col-12 col-md-6">
                    <label class="form-label text-white">Origin Country*</label>
                    <select class="form-select @error('origin_country') is-invalid @enderror" id="origin_country" name="origin_country" data-old="{{ old('origin_country') }}">
                        <option value="">Select Country</option>
                    </select>
                    @error('origin_country')
                        <div class="invalid-feedback d-block text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label text-white">Destination Country*</label>
                    <select class="form-select @error('destination_country') is-invalid @enderror" id="destination_country" name="destination_country" data-old="{{ old('destination_country') }}">
                        <option value="">Select Country</option>
                    </select>
                    @error('destination_country')
                        <div class="invalid-feedback d-block text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

               <div class="col-12">
                   <label class="form-label">Estimated Shipment Volume per month *</label>
                   <input type="text" class="form-control inputbox @error('estimated_shipment_volume') is-invalid @enderror" placeholder="Estimated Shipment Volume per month*" name="estimated_shipment_volume" value="{{ old('estimated_shipment_volume') }}">
                   @error('estimated_shipment_volume')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-12">
                   <label class="form-label">What are you looking for?</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Speed" name="looking_for[]" value="Speed" {{ (is_array(old('looking_for')) && in_array('Speed', old('looking_for'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Speed">Speed</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Cost" name="looking_for[]" value="Cost" {{ (is_array(old('looking_for')) && in_array('Cost', old('looking_for'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Cost">Cost</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Trust" name="looking_for[]" value="Trust" {{ (is_array(old('looking_for')) && in_array('Trust', old('looking_for'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Trust">Trust</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Visibility" name="looking_for[]" value="Visibility" {{ (is_array(old('looking_for')) && in_array('Visibility', old('looking_for'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Visibility">Visibility</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Flexibility" name="looking_for[]" value="Flexibility" {{ (is_array(old('looking_for')) && in_array('Flexibility', old('looking_for'))) ? 'checked' : '' }}>
                           <label class="form-check-label" for="Flexibility">Flexibility</label>
                       </div>
                   </div>
                   @error('looking_for')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-md-6">
                   <label class="form-label">Name</label>
                   <input type="text" class="form-control inputbox @error('name') is-invalid @enderror" placeholder="Name*" name="name" value="{{ old('name') }}">
                   @error('name')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-md-6">
                   <label class="form-label">Designation</label>
                   <input type="text" class="form-control inputbox @error('designation') is-invalid @enderror" placeholder="Designation*" name="designation" value="{{ old('designation') }}">
                   @error('designation')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

               <div class="col-md-6">
                   <label class="form-label">Email</label>
                   <input type="email" class="form-control inputbox @error('email') is-invalid @enderror" placeholder="Email*" name="email" value="{{ old('email') }}">
                   @error('email')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>

                <div class="mb-3 col-12 col-md-6">
                    <label class="form-label text-white">WhatsApp/Phone*</label>
                    <input type="tel" name="whatsapp_phone" class="form-control iti__tel-input @error('whatsapp_phone') is-invalid @enderror"
                        value="{{ old('whatsapp_phone') }}">
                    @error('whatsapp_phone')
                        <div class="invalid-feedback d-block text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
               <div class="col-12">
                   <label class="form-label">Let us know how we can support you</label>
                   <input type="text" class="form-control inputbox @error('additional_details') is-invalid @enderror" placeholder="Where are your shipments to/from? Any additional details you would like us to know?" name="additional_details" value="{{ old('additional_details') }}">
                   @error('additional_details')
                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                    @enderror
               </div>
               <div class="col-12">
                   <label class="form-label">Consent</label>
                   <div class="form-check">
                       <input class="form-check-input checkboxpadding @error('consent') is-invalid @enderror" type="checkbox" id="consent" name="consent" value="1" {{ old('consent') ? 'checked' : '' }}>
                       <label class="form-check-label" for="consent">By submitting this form, you consent to FR8NITY sharing your shipment details with relevant and trusted freight partners within our network for the purpose of quotation and coordination. We do not sell your data or pass it to third parties outside the network.</label>
                       @error('consent')
                            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                        @enderror
                   </div>
               </div>

               <div class="d-flex justify-content-center align-items-center">
                   <button type="submit" class="btn btnbg fw-semibold mt-4">Submit</button>
               </div>
           </div>
       </form>
   </div>
</section>
<script src="{{asset('js/joinMember.js?v=' . rand(1, 1000000))}}"></script>
@endsection 