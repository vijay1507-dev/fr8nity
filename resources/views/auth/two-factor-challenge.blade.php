@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Two Factor Authentication</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('two-factor.verify') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="two_factor_code" class="form-label">Authentication Code</label>
                            <input id="two_factor_code" type="text" 
                                   class="form-control @error('two_factor_code') is-invalid @enderror" 
                                   name="two_factor_code" required autofocus>
                            <div class="form-text">
                                Please enter the authentication code that was sent to your email.
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                Verify
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 