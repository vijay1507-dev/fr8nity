@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>2FA Settings</h4>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Two-Factor Authentication</h5>

                        @if(auth()->user()->two_factor_enabled)
                            <div class="alert alert-success">
                                <i class="fas fa-shield-alt"></i> Two-factor authentication is currently enabled.
                            </div>
                            <form action="{{ route('two-factor.disable') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Disable Two-Factor Authentication
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Two-factor authentication is currently disabled.
                            </div>
                            <form action="{{ route('two-factor.enable') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Enable Two-Factor Authentication
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="mt-4">
                        <h6>How it works:</h6>
                        <ol class="text-muted">
                            <li>When you log in with your password, we'll send a code to your email.</li>
                            <li>You'll need to enter this code to complete the login process.</li>
                            <li>The code expires after 10 minutes for security.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 