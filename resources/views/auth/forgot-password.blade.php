@extends('layouts.auth')

@section('title', 'Forgot-password')

@section('content')
<body>
  <section class="bg-black p-0">
      <div class="container_ w-100">
        <div class="row justify-content-center mx-0">
          <div class="col-12 p-0">
            <div class="m-0">
              <div class="row g-0">
                <div class="col-12 col-md-6 p-0 login_img  d-none d-lg-block">
                  <img class="img-fluid rounded-start w-100 object-fit-cover" loading="lazy"
                    src="{{asset('images/admin-login.webp')}}" alt="Reset Password">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                  <div class="col-12 col-md-10 col-lg-11 col-xl-10">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                      <div class="row">
                        <div class="col-12">
                          <div class="mb-4">
                            <div class="text-center mb-4">
                              <a href="/">
                                <img src="{{asset('images/logo.svg')}}" alt="Logo" width="auto" height="78">
                              </a>
                            </div>
                            <h4 class="text-center h2 pb-3 text-white">Reset Password</h4>
                            <p class="text-center text-secondary">Enter your email address and we'll send you a link to reset your password.</p>
                          </div>
                        </div>
                      </div>

                      @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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

                      <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row gy-3 overflow-hidden">
                          <div class="col-12">
                            <div class="">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                              placeholder="Email Address" required autofocus>
                          
                          </div>
                          </div>
                          <div class="col-12">
                            <div class="d-grid">
                              <button class="btn btn-primary btn-md" type="submit">Send Reset Link</button>
                            </div>
                          </div>
                          <div class="col-12 text-center">
                            <a href="{{ route('login') }}" class="text-white text-decoration-underline">
                              <i class="bi bi-arrow-left"></i> Back to Login
                            </a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</body>
@endsection
