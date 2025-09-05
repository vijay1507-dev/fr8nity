@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="membership_reminder_days" class="form-label text-bold mb-2">Membership Expiry Reminder Days</label>
                            <input type="number" 
                                   class="form-control @error('membership_reminder_days') is-invalid @enderror" 
                                   id="membership_reminder_days" 
                                   name="membership_reminder_days" 
                                   value="{{ old('membership_reminder_days', $reminderDays) }}"
                                   min="1"
                                   max="90">
                            <small class="form-text text-muted">Number of days before membership expiry to start sending reminder emails (1-90 days)</small>
                            @error('membership_reminder_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="renewal_days_prior_expiring" class="form-label text-bold mb-2">Renewal Days of Prior Expiring</label>
                            <input type="number" 
                                   class="form-control @error('renewal_days_prior_expiring') is-invalid @enderror" 
                                   id="renewal_days_prior_expiring" 
                                   name="renewal_days_prior_expiring" 
                                   value="{{ old('renewal_days_prior_expiring', $renewalDaysPriorExpiring ?? 30) }}"
                                   min="1"
                                   max="365">
                            <small class="form-text text-muted">Number of days before membership expiry to consider as early renewal (1-365 days)</small>
                            @error('renewal_days_prior_expiring')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection