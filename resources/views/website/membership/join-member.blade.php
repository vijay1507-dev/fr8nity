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

       <form>
           <div class="form-section row g-3">
               <div class="col-md-6">
                   <label class="form-label">Company Name</label>
                   <input type="text" class="form-control  inputbox" placeholder="Company Name*">
               </div>
               <div class="col-md-6">
                   <label class="form-label">Product/Industry Category</label>
                   <input type="text" class="form-control inputbox" placeholder="Product/Industry Category*">
               </div>

               <div class="col-md-6">
                   <label class="form-label">Shipping Frequency</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap ">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Daily">
                           <label class="form-check-label" for="Daily">Daily</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Weekly">
                           <label class="form-check-label " for="Weekly">Weekly</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Monthly">
                           <label class="form-check-label " for="Monthly">Monthly</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="hoc">
                           <label class="form-check-label" for="hoc">Ad-hoc</label>
                       </div>
                   </div>
               </div>

               <div class="col-md-6">
                   <label class="form-label">Mode of shipment</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap ">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkAir">
                           <label class="form-check-label" for="checkAir">Air</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkSea">
                           <label class="form-check-label" for="checkSea">Sea</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="checkLand">
                           <label class="form-check-label" for="checkLand">Land</label>
                       </div>
                   </div>
               </div>

               <div class="col-md-6">
                   <label class="form-label">Origin Country</label>
                   <input type="text" class="form-control inputbox" placeholder="Origin Country*">
               </div>

               <div class="col-md-6">
                   <label class="form-label">Destination Country</label>
                   <input type="text" class="form-control inputbox" placeholder="Destination Country*">
               </div>

               <div class="col-12">
                   <label class="form-label">Estimated Shipment Volume per month *</label>
                   <input type="text" class="form-control inputbox" placeholder="Estimated Shipment Volume per month*">
               </div>

               <div class="col-12">
                   <label class="form-label">What are you looking for?</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap ">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Speed">
                           <label class="form-check-label" for="Speed">Speed</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Cost">
                           <label class="form-check-label" for="Cost">Cost</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Trust">
                           <label class="form-check-label" for="Trust">Trust</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Visibility">
                           <label class="form-check-label" for="Visibility">Visibility</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Flexibility">
                           <label class="form-check-label" for="Flexibility">Flexibility</label>
                       </div>
                   </div>
               </div>

               <div class="col-md-6">
                   <label class="form-label">Name</label>
                   <input type="text" class="form-control inputbox" placeholder="Name*">
               </div>

               <div class="col-md-6">
                   <label class="form-label">Designation</label>
                   <input type="text" class="form-control inputbox" placeholder="Designation*">
               </div>

               <div class="col-md-6">
                   <label class="form-label">Email</label>
                   <input type="email" class="form-control inputbox" placeholder="Email*">
               </div>

               <div class="col-md-6">
                   <label class="form-label">WhatsApp/Phone</label>
                   <input type="tel" class="form-control inputbox" placeholder="WhatsApp/Phone*">
               </div>
               <div class="col-12">
                   <label class="form-label">Let us know how we can support you</label>
                   <input type="text" class="form-control inputbox" placeholder="Where are your shipments to/from? Any additional details you would like us to know?">
               </div>
               <div class="col-12">
                   <label class="form-label">Consent</label>
                   <div class="form-check">
                       <input class="form-check-input checkboxpadding" type="checkbox" id="verifiedforwarder">
                       <label class="form-check-label" for="verifiedforwarder">By submitting this form, you consent to FR8NITY sharing your shipment details with relevant and trusted freight partners within our network for the purpose of quotation and coordination. We do not sell your data or pass it to third parties outside the network.</label>
                   </div>
               </div>

               <div class="d-flex justify-content-center align-items-center">
                   <button type="button" class="btn btnbg fw-semibold mt-4">Submit</button>
               </div>
           </div>
       </form>
   </div>
</section>
@endsection 