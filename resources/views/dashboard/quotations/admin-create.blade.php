@extends('layouts.dashboard')
  
@section('title', 'Add Offline Quotation')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Add Offline Quotation</h4>
                    <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary d-inline-flex align-items-center gap-2 flex-nowrap">
                        <i class="bi bi-arrow-left"></i>Back to Quotations
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.quotations.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Member Selection Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="given_by_id" class="form-label">Giver Member*</label>
                                    <select class="form-control @error('given_by_id') is-invalid @enderror" name="given_by_id" id="given_by_id" required>
                                        <option value="">Select giver member</option>
                                        @if(isset($members) && count($members) > 0)
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('given_by_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->name }} - {{ $member->company_name }}
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
                                    <label for="receiver_id" class="form-label">Receiver Member*</label>
                                    <select class="form-control @error('receiver_id') is-invalid @enderror" name="receiver_id" id="receiver_id" required>
                                        <option value="">Select receiver member</option>
                                        @if(isset($members) && count($members) > 0)
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('receiver_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->name }} - {{ $member->company_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('receiver_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Value -->
                        <div class="row">
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

                        <!-- Port Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="port_of_loading_id" class="form-label">Port of Loading</label>
                                    <select class="form-control @error('port_of_loading_id') is-invalid @enderror" name="port_of_loading_id" id="port_of_loading_id">
                                        <option value="">Select port of loading</option>
                                        @if(isset($ports) && count($ports) > 0)
                                            @foreach($ports as $port)
                                                <option value="{{ $port->id }}" {{ old('port_of_loading_id') == $port->id ? 'selected' : '' }}>
                                                    {{ $port->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('port_of_loading_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="port_of_discharge_id" class="form-label">Port of Discharge</label>
                                    <select class="form-control @error('port_of_discharge_id') is-invalid @enderror" name="port_of_discharge_id" id="port_of_discharge_id">
                                        <option value="">Select port of discharge</option>
                                        @if(isset($ports) && count($ports) > 0)
                                            @foreach($ports as $port)
                                                <option value="{{ $port->id }}" {{ old('port_of_discharge_id') == $port->id ? 'selected' : '' }}>
                                                    {{ $port->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('port_of_discharge_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="form-group mb-3">
                            <label class="form-label">Specifications</label>
                            <div class="row">
                                @php
                                    $specifications = ['Air', 'FCL', 'LCL', 'Land', 'Multimodal', 'Project Cargo'];
                                @endphp
                                @foreach($specifications as $spec)
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="specifications[]" 
                                                   value="{{ $spec }}" id="spec_{{ $loop->index }}"
                                                   {{ in_array($spec, old('specifications', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="spec_{{ $loop->index }}">
                                                {{ $spec }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message*</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="4" 
                                      placeholder="Enter quotation message..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Add Offline Quotation
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
    // Form validation enhancement
    document.getElementById('transaction_value').addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });
    
    // Prevent selecting the same member for giver and receiver
    document.getElementById('given_by_id').addEventListener('change', function() {
        const receiverSelect = document.getElementById('receiver_id');
        const selectedGiverId = this.value;
        
        // Reset receiver if it's the same as giver
        if (receiverSelect.value === selectedGiverId) {
            receiverSelect.value = '';
        }
        
        // Update receiver options to disable the selected giver
        Array.from(receiverSelect.options).forEach(option => {
            if (option.value === selectedGiverId && option.value !== '') {
                option.disabled = true;
                option.style.display = 'none';
            } else {
                option.disabled = false;
                option.style.display = 'block';
            }
        });
    });
    
    document.getElementById('receiver_id').addEventListener('change', function() {
        const giverSelect = document.getElementById('given_by_id');
        const selectedReceiverId = this.value;
        
        // Reset giver if it's the same as receiver
        if (giverSelect.value === selectedReceiverId) {
            giverSelect.value = '';
        }
        
        // Update giver options to disable the selected receiver
        Array.from(giverSelect.options).forEach(option => {
            if (option.value === selectedReceiverId && option.value !== '') {
                option.disabled = true;
                option.style.display = 'none';
            } else {
                option.disabled = false;
                option.style.display = 'block';
            }
        });
    });
</script>
@endsection