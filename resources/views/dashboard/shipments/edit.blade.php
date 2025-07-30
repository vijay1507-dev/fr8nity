@extends('layouts.dashboard')
@section('title', 'Edit Shipment Enquiry')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Shipment Enquiry</h4>
                <div>
                    <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('shipments.update', $shipment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Shipment Information</h5>
                        
                        <div class="mb-3">
                            <label for="shipment_type" class="form-label">Shipment Types *</label>
                            @php
                                $types = $shipment->shipment_type;
                                if (is_string($types)) {
                                    $types = json_decode($types, true);
                                }
                                $types = is_array($types) ? $types : [];
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="shipment_type[]" value="FCL" id="fcl" 
                                    {{ in_array('FCL', $types) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fcl">FCL (Full Container Load)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="shipment_type[]" value="LCL" id="lcl"
                                    {{ in_array('LCL', $types) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lcl">LCL (Less Container Load)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="shipment_type[]" value="Air Freight" id="air"
                                    {{ in_array('Air Freight', $types) ? 'checked' : '' }}>
                                <label class="form-check-label" for="air">Air Freight</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="shipment_type[]" value="Road Transport" id="road"
                                    {{ in_array('Road Transport', $types) ? 'checked' : '' }}>
                                <label class="form-check-label" for="road">Road Transport</label>
                            </div>
                            @error('shipment_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mode_of_transport" class="form-label">Mode of Transport *</label>
                            <select class="form-select" name="mode_of_transport" required>
                                <option value="">Select Mode of Transport</option>
                                <option value="Sea Freight" {{ $shipment->mode_of_transport == 'Sea Freight' ? 'selected' : '' }}>Sea Freight</option>
                                <option value="Air Freight" {{ $shipment->mode_of_transport == 'Air Freight' ? 'selected' : '' }}>Air Freight</option>
                                <option value="Road Transport" {{ $shipment->mode_of_transport == 'Road Transport' ? 'selected' : '' }}>Road Transport</option>
                                <option value="Rail Transport" {{ $shipment->mode_of_transport == 'Rail Transport' ? 'selected' : '' }}>Rail Transport</option>
                                <option value="Multimodal" {{ $shipment->mode_of_transport == 'Multimodal' ? 'selected' : '' }}>Multimodal</option>
                            </select>
                            @error('mode_of_transport')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="goods_description" class="form-label">Goods Description *</label>
                            <textarea class="form-control" name="goods_description" rows="3" required>{{ old('goods_description', $shipment->goods_description) }}</textarea>
                            @error('goods_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estimated_volume" class="form-label">Estimated Volume *</label>
                            <input type="text" class="form-control" name="estimated_volume" value="{{ old('estimated_volume', $shipment->estimated_volume) }}" required>
                            @error('estimated_volume')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cargo_ready_date" class="form-label">Cargo Ready Date *</label>
                            <input type="date" class="form-control" name="cargo_ready_date" value="{{ old('cargo_ready_date', $shipment->cargo_ready_date->format('Y-m-d')) }}" required>
                            @error('cargo_ready_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Location Details</h5>
                        
                        <div class="mb-3">
                            <label for="pickup_country_id" class="form-label">Pickup Country *</label>
                            <select class="form-select" name="pickup_country_id" id="pickup_country_id" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('pickup_country_id', $shipment->pickup_country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pickup_country_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pickup_city_id" class="form-label">Pickup City *</label>
                            <select class="form-select" name="pickup_city_id" id="pickup_city_id" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    @if($city->country_id == $shipment->pickup_country_id)
                                        <option value="{{ $city->id }}" {{ old('pickup_city_id', $shipment->pickup_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('pickup_city_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination_country_id" class="form-label">Destination Country *</label>
                            <select class="form-select" name="destination_country_id" id="destination_country_id" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('destination_country_id', $shipment->destination_country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_country_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination_city_id" class="form-label">Destination City *</label>
                            <select class="form-select" name="destination_city_id" id="destination_city_id" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    @if($city->country_id == $shipment->destination_country_id)
                                        <option value="{{ $city->id }}" {{ old('destination_city_id', $shipment->destination_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('destination_city_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">Documents</label>
                            <input type="file" class="form-control" name="documents" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Max file size: 10MB. Supported formats: PDF, DOC, DOCX, JPG, PNG</small>
                            @if($shipment->documents)
                                <div class="mt-2">
                                    <small class="text-muted">Current document: <a href="{{ Storage::url($shipment->documents) }}" target="_blank">View Document</a></small>
                                </div>
                            @endif
                            @error('documents')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Additional Information</h5>
                        
                        <div class="mb-3">
                            <label for="special_notes" class="form-label">Special Notes</label>
                            <textarea class="form-control" name="special_notes" rows="3">{{ old('special_notes', $shipment->special_notes) }}</textarea>
                            @error('special_notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_remark" class="form-label">Delivery Remarks</label>
                            <textarea class="form-control" name="delivery_remark" rows="3">{{ old('delivery_remark', $shipment->delivery_remark) }}</textarea>
                            @error('delivery_remark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="consent" value="1" id="consent" required {{ $shipment->consent ? 'checked' : '' }}>
                                <label class="form-check-label" for="consent">
                                    I agree to the terms and conditions *
                                </label>
                            </div>
                            @error('consent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Shipment Enquiry
                        </button>
                        <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle pickup country change
    $('#pickup_country_id').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.get('/get-cities/' + countryId, function(data) {
                $('#pickup_city_id').empty();
                $('#pickup_city_id').append('<option value="">Select City</option>');
                $.each(data, function(key, value) {
                    $('#pickup_city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            });
        } else {
            $('#pickup_city_id').empty();
            $('#pickup_city_id').append('<option value="">Select City</option>');
        }
    });

    // Handle destination country change
    $('#destination_country_id').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.get('/get-cities/' + countryId, function(data) {
                $('#destination_city_id').empty();
                $('#destination_city_id').append('<option value="">Select City</option>');
                $.each(data, function(key, value) {
                    $('#destination_city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            });
        } else {
            $('#destination_city_id').empty();
            $('#destination_city_id').append('<option value="">Select City</option>');
        }
    });
});
</script>
@endpush
@endsection 