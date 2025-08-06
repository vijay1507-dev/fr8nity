@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">My Referrals</h3>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-4">
                <h4>Referral Link</h4>
                <div class="input-group">
                    <input type="text" id="referralLink" class="form-control" value="{{ auth()->user()->getReferralLink() }}" readonly>
                    <button class="btn btn-primary copy-btn" id="copyReferralBtn">
                        <i class="bi bi-clipboard"></i> Copy Link
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Referred User</th>
                            <th>Company</th>
                            <th>Registered Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td>{{ $referral->referred->name }}</td>
                                <td>{{ $referral->referred->company_name }}</td>
                                <td>{{ $referral->registered_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $referral->referred->status === 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($referral->referred->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No referrals yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $referrals->links() }}
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{ asset('js/referrals.js') }}?v={{rand(1,1000000000)}}"></script>
@endsection
@endsection