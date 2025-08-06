@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4">All Referrals</h3>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Referrer</th>
                            <th>Referred User</th>
                            <th>Referrer Companies</th>
                            <th>Referred Companies</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td>
                                    <div>{{ $referral->referrer->name }}</div>
                                    <small class="text-muted">{{ $referral->referrer->email }}</small>
                                </td>
                                <td>
                                    <div>{{ $referral->referred->name }}</div>
                                    <small class="text-muted">{{ $referral->referred->email }}</small>
                                </td>
                                <td>
                                    <div>{{ $referral->referrer->company_name }}</div>
                                </td>
                                <td>
                                    <div>{{ $referral->referred->company_name }}</div>
                                </td>
                                <td>{{ $referral->registered_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $referral->referred->status === 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($referral->referred->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No referrals found</td>
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
@endsection