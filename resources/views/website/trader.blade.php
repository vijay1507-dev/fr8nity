@extends('layouts.website')

@section('title', 'Trader')

@section('content')
   

<section class="trader_sec">
     <div class="col-12 col-md-8 mx-auto bg-dark p-5 rounded my-5">
        <div class="tittle d-flex justify-content-center align-items-center">
            <h1 class="mb-4 fw-semibold text-center">Looking for a Trusted <br>Freight Partner?</h1>
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
                    <label class="form-label">Freight Specializations</label>
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
                    <label class="form-label">Consent</label>
                    <div class="form-check">
                        <input class="form-check-input checkboxpadding" type="checkbox" id="verifiedforwarder">
                        <label class="form-check-label" for="verifiedforwarder">I want to be matched with a verified
                            forwarder</label>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btnbg fw-semibold mt-4">Connect Me With a Forwarder</button>
                </div>
            </div>
        </form>
    </div>
</section>


@endsection
