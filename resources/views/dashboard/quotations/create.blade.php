@extends('layouts.dashboard')
  
@section('title', 'Create Quotation')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Create New Quotation</h4>
                    <a href="{{ route('member.quotations.received') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Received Quotations
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('member.quotations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="is_offline_enquiry" value="1">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="given_by_id" class="form-label">Select Member*</label>
                                    <select class="form-control @error('given_by_id') is-invalid @enderror" name="given_by_id" id="given_by_id" required>
                                        <option value="">Select a member</option>
                                        @if(isset($members) && count($members) > 0)
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('given_by_id') == $member->id ? 'selected' : '' }}>
                                                    {{$member->name}} - {{ $member->company_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('given_by_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="transaction_value" class="form-label">Transaction Value*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('transaction_value') is-invalid @enderror" 
                                               id="transaction_value" name="transaction_value" 
                                               placeholder="Enter transaction value" value="{{ old('transaction_value') }}" 
                                               step="0.01" min="0" required>
                                    </div>
                                    @error('transaction_value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message*</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="4" 
                                      placeholder="Enter your quotation message..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Submit Quotation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-select member if coming from search
    @if(request('receiver_id'))
        document.getElementById('receiver_id').value = '{{ request('receiver_id') }}';
    @endif

    // Form validation enhancement
    document.getElementById('transaction_value').addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });
</script>
@endsection
