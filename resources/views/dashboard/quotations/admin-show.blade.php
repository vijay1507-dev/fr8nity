@extends('layouts.dashboard')

@section('title', 'Quotation Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="page-title">Quotation Details</h4>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
                            <span class="d-none d-md-inline">Back</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Sender Information</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="150"><strong>Company Name:</strong></td>
                                        <td>{{ $quotation->member->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="180"><strong>Name:</strong></td>
                                        <td>{{ $quotation->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $quotation->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $quotation->phone }}</td>
                                    </tr>
                                    @if ($quotation->alternate_email)
                                        <tr>
                                            <td><strong>Alternate Email:</strong></td>
                                            <td>{{ $quotation->alternate_email }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Receiver (Member) Information</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="180"><strong>Company:</strong></td>
                                        <td>{{ optional($quotation->member)->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Person:</strong></td>
                                        <td>{{ optional($quotation->member)->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ optional($quotation->member)->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ optional($quotation->member)->company_telephone }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5 class="mb-3">Quotation Details</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="180"><strong>Date:</strong></td>
                                        <td>{{ $quotation->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @if (!empty($quotation->specifications))
                                        <tr>
                                            <td><strong>Specifications:</strong></td>
                                            <td>{{ implode(', ', $quotation->specifications) }}</td>
                                        </tr>
                                    @endif
                                    @if ($quotation->port_of_loading_id)
                                        <tr>
                                            <td><strong>Port of Loading:</strong></td>
                                            <td>{{ $quotation->portOfLoading->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($quotation->port_of_discharge_id)
                                        <tr>
                                            <td><strong>Port of Discharge:</strong></td>
                                            <td>{{ $quotation->portOfDischarge->name }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Message</h5>
                                <div class="border rounded p-3 bg-light">
                                    {{ $quotation->message }}
                                </div>
                            </div>
                        </div>

                        @if ($quotation->uploaded_document)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5 class="mb-3">Attached Document</h5>
                                    <a href="{{ Storage::url($quotation->uploaded_document) }}" class="btn btn-primary"
                                        target="_blank">
                                        View Document
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
