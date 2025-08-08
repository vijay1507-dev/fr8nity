@extends('layouts.dashboard')
@section('title', 'Shipment Enquiry Details')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Shipment Enquiry Details</h4>
                <div>
                    <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-success">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Shipment Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Shipment Types:</strong></td>
                            <td>
                                @php
                                    $types = $shipment->shipment_type;
                                    if (is_string($types)) {
                                        $types = json_decode($types, true);
                                    }
                                    echo is_array($types) ? implode(', ', $types) : $types;
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Mode of Transport:</strong></td>
                            <td>{{ $shipment->mode_of_transport }}</td>
                        </tr>
                        <tr>
                            <td><strong>Goods Description:</strong></td>
                            <td>{{ $shipment->goods_description }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estimated Volume:</strong></td>
                            <td>{{ $shipment->estimated_volume }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cargo Ready Date:</strong></td>
                            <td>{{ $shipment->cargo_ready_date->format('F j, Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Location Details</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Pickup Location:</strong></td>
                            <td>{{ $shipment->pickupCity->name }}, {{ $shipment->pickupCountry->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Destination Location:</strong></td>
                            <td>{{ $shipment->destinationCity->name }}, {{ $shipment->destinationCountry->name }}</td>
                        </tr>
                    </table>
                    <div class="col-md-6">
                        <h5 class="mb-3">Contact Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Sender Name:</strong></td>
                                <td>{{ $shipment->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $shipment->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $shipment->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Company Name:</strong></td>
                                <td>{{ $shipment->company_name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
            </div>

            @if($shipment->special_notes)
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">Special Notes</h5>
                    <div class="alert alert-info">
                        {{ $shipment->special_notes }}
                    </div>
                </div>
            </div>
            @endif

            @if($shipment->delivery_remark)
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">Delivery Remarks</h5>
                    <div class="alert alert-warning">
                        {{ $shipment->delivery_remark }}
                    </div>
                </div>
            </div>
            @endif

            @if($shipment->documents)
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">Documents</h5>
                    <div class="alert alert-success">
                        <a href="{{ Storage::url($shipment->documents) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Download Documents
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">Additional Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Created At:</strong></td>
                            <td>{{ $shipment->created_at->format('F j, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Back Button -->
    <div class="position-fixed bottom-0 end-0 p-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left" style="font-size: 15px;"></i>
            <span class="d-none d-md-inline">Back</span>
        </a>
    </div>
</div>
@endsection 