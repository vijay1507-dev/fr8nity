@extends('layouts.dashboard')

@section('title', 'Quotation Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="page-title">{{ $quotation->given_by_id === Auth::id() ? 'Given' : 'Received' }} Quotations</h4>
                    <a href="{{ $quotation->given_by_id === Auth::id() ? route('member.quotations.given') : route('member.quotations.received') }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
                        <span class="d-none d-md-inline">Back</span>
                    </a>
                </div>
                <div class="card-body">
                    <!-- Reference Number Section -->
                    @if($quotation->quotation_reference_no)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>Reference Number:</strong> {{ $quotation->quotation_reference_no }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">{{ $quotation->given_by_id === Auth::id() ? 'Submitted to' : 'Received from' }} :</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150"><strong>Company Name:</strong></td>
                                    <td>{{ $quotation->given_by_id === Auth::id() ? $quotation->receiver->company_name : $quotation->givenBy->company_name }}</td>
                                </tr>
                                <tr>
                                    <td width="150"><strong>Name:</strong></td>
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
                                @if($quotation->alternate_email)
                                <tr>
                                    <td><strong>Alternate Email:</strong></td>
                                    <td>{{ $quotation->alternate_email }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Enquiry Details</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150"><strong>Date:</strong></td>
                                    <td>{{ $quotation->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @if(!empty($quotation->specifications))
                                <tr>
                                    <td><strong>Specifications:</strong></td>
                                    <td>{{ implode(', ', $quotation->specifications) }}</td>
                                </tr>
                                @endif
                                @if($quotation->port_of_loading_id)
                                <tr>
                                    <td><strong>Port of Loading:</strong></td>
                                    <td>{{ $quotation->portOfLoading->name }}</td>
                                </tr>
                                @endif
                                @if($quotation->port_of_discharge_id)
                                <tr>
                                    <td><strong>Port of Discharge:</strong></td>
                                    <td>{{ $quotation->portOfDischarge->name }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class="mb-3">Message</h5>
                            <div class="border rounded p-3 bg-light">
                                {{ $quotation->message }}
                            </div>
                        </div>
                    </div>

					@if(is_null($quotation->status))
					<div class="row mt-3">
						<div class="col-12 d-flex gap-2">
							<form action="{{ route('member.quotations.close', $quotation) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this enquiry as unsuccessful?');">
								@csrf
								@method('PATCH')
								<button type="submit" class="btn btn-outline-danger">Quotation Unsuccessful</button>
							</form>

							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#markSuccessModal">
								Quotation Successful
							</button>
						</div>
					</div>
					@endif

                    @if($quotation->uploaded_document)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class="mb-3">Attached Document</h5>
                            <a href="{{ Storage::url($quotation->uploaded_document) }}" 
                               class="btn btn-primary" 
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

@if(is_null($quotation->status))
<!-- Success Modal -->
<div class="modal fade" id="markSuccessModal" tabindex="-1" aria-labelledby="markSuccessModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="markSuccessModalLabel">Mark Quotation as Successful</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('member.quotations.success', $quotation) }}" method="POST">
				@csrf
				@method('PATCH')
				<div class="modal-body">
					<div class="mb-3">
						<label for="transaction_value" class="form-label">Transaction value</label>
						<input type="number" name="transaction_value" id="transaction_value" class="form-control" min="0" step="0.01" required placeholder="Enter transaction value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endsection
