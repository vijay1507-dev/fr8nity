@extends('layouts.website')

@section('title', 'Submit Shipment Enquiry - Fr8nity')

@section('content')
<section class="trader_sec">
    <div class="col-12 col-md-8 mx-auto bg-dark p-5 rounded my-5">
       <div class="tittle d-flex justify-content-center align-items-center">
          <div class="pb-3">  <h1 class="mb-4 fw-semibold text-center">Shipment Enquiry form</h1>
           </div>

       </div>

       <form>
           <div class="form-section row g-3">
              <div class="col-md-6">
                   <label class="form-label">Shipment Type (Choose one or more)</label>
                   <div class="checkbox-group d-flex gap-3 bg-black p-2 rounded align-items-center px-3 flex-wrap ">
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Import">
                           <label class="form-check-label" for="Import">Import</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="Export">
                           <label class="form-check-label " for="Export">Export</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input checkboxpadding" type="checkbox" id="CrossTrade">
                           <label class="form-check-label " for="CrossTrade">Cross Trade</label>
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
                   <label class="form-label">Mode of Transport</label>
                   <select class="form-select" aria-label="Default select example">
                        <option selected>Select Mode of Transport</option>
                        <option value="1">Air</option>
                        <option value="2">Sea</option>
                        <option value="3">Land / Trucking</option>
                        <option value="3">OOG/Breakbulk/Project</option>
                    </select>
               </div>
               <h4 class="text-white mb-0 mt-4">Shipment Information</h4>
               <div class="col-md-6">
                   <label class="form-label">Goods Description</label>
                   <input type="text" class="form-control inputbox" placeholder="Goods Description">
               </div>
                <div class="col-md-6">
                   <label class="form-label">Estimated Volume / Weight</label>
                   <input type="text" class="form-control inputbox" placeholder="Estimated Volume / Weight">
               </div>
                 <div class="col-md-6">
                   <label class="form-label">Cargo Ready Date</label>
                   <input type="date" class="form-control inputbox" placeholder="Cargo Ready Date">
               </div>
               <div class="col-md-6">
                   <label class="form-label">Pickup City & Country</label>
                   <input type="text" class="form-control inputbox" placeholder="Pickup City & Country">
               </div>
                <div class="col-md-6">
                   <label class="form-label">Destination City & Country</label>
                   <input type="text" class="form-control inputbox" placeholder="Destination City & Country">
               </div>
                 <div class="col-md-6">
                   <label class="form-label">Upload Documents</label>
                   <input type="file" class="form-control inputbox" placeholder="Upload Documents">
               </div>
                <div class="col-md-12">
                   <label class="form-label">Any Special Handling or Notes? </label>
                   <input type="text" class="form-control inputbox" placeholder="Any Special Handling or Notes? ">
               </div>

                <div class="col-md-12">
                   <label class="form-label">Delivery Remark </label>
                   <textarea class="form-control inputbox" rows="4" placeholder="Delivery Remark"></textarea>
               </div>

             
               <div class="col-12">
                   <div class="form-check">
                       <input class="form-check-input checkboxpadding" type="checkbox" id="verifiedforwarder">
                       <label class="form-check-label" for="verifiedforwarder">By submitting this form, you consent to FR8NITY sharing your shipment details with relevant and trusted freight partners within our network for
 the purpose of quotation and coordination. We do not sell your data or pass it to third parties outside the network.</label>
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