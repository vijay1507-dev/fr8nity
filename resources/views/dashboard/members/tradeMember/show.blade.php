@extends('layouts.dashboard')
@section('title', 'View Trade Member')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Trade Member Details</h4>
            <div>
                <a href="{{ route('trade-members.edit', $tradeMember) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('trade-members.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-4">Personal Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Name</th>
                            <td>{{ $tradeMember->name }}</td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td>{{ $tradeMember->designation }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $tradeMember->email }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp/Phone</th>
                            <td>{{ $tradeMember->whatsapp_phone }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-4">Company Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Company Name</th>
                            <td>{{ $tradeMember->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Product/Industry Category</th>
                            <td>{{ $tradeMember->product_industry_category }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Frequency</th>
                            <td>
                                @if($tradeMember->shipping_frequency)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($tradeMember->shipping_frequency as $frequency)
                                            <li><i class="fas fa-check text-success me-2"></i>{{ $frequency }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Mode of Shipment</th>
                            <td>
                                @if($tradeMember->mode_of_shipment)
                                    <ul class="list-unstyled mb-0">
                                        @foreach(($tradeMember->mode_of_shipment) as $mode)
                                            <li><i class="fas fa-check text-success me-2"></i>{{ $mode }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5 class="mb-4">Shipment Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Origin Country</th>
                            <td>{{ optional($tradeMember->originCountry)->name }}</td>
                        </tr>
                        <tr>
                            <th>Destination Country</th>
                            <td>{{ optional($tradeMember->destinationCountry)->name }}</td>
                        </tr>
                        <tr>
                            <th>Estimated Shipment Volume</th>
                            <td>{{ $tradeMember->estimated_shipment_volume }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-4">Additional Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Looking For</th>
                            <td>
                                @if($tradeMember->looking_for)
                                    <ul class="list-unstyled mb-0">
                                        @foreach(($tradeMember->looking_for) as $item)
                                            <li><i class="fas fa-check text-success me-2"></i>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Additional Details</th>
                            <td>{{ $tradeMember->additional_details }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 