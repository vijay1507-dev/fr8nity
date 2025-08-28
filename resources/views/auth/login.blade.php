@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<body >
  <section class="p-0">
      <div class="w-100 userlogin">
        <div class="row bg-black justify-content-center mx-0">
          <div class="col-12 p-0">
            <div class="m-0">
              <div class="row g-0">
                <div class="col-12 col-md-6 p-0 login_img d-none d-lg-block">
                  <img class="img-fluid rounded-start w-100 object-fit-cover imghide" loading="lazy"
                    src="{{asset('images/admin-login.webp')}}" alt="Welcome back!">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center custom-card">
                  <div class="col-12  col-md-10  col-lg-11 ">
                    <div class="card-body p-3 p-md-4 p-xl-5 ">
                      <div class="row">
                        <div class="col-12  d-flex align-items-center justify-content-center">
                          <div class="mb-4">
                            <div class="text-center mb-4">
                              <a href="/">
                                <img src="{{asset('images/logo.svg')}}" alt="Logo" width="auto" height="78">
                              </a>
                            </div>
                            <h4 class="text-center h2 pb-3 text-white">Login</h4>
                          </div>
                        </div>
                      </div>
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                      @if (session('success'))
                        <div class="alert alert-success">
                          {{ session('success') }}
                        </div>
                      @endif
                      <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        <input type="hidden" name="is_member" value="true">
                        <div class="row gy-3 overflow-hidden">
                          <div class="col-12">
                            <div class="">
                                <label for="email" class="form-label text-white">Email Address*</label>
                              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Email Address">
                            
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="mb-1">
                                   <label for="password" class="form-label text-white">Password*</label>
                              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                         
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="1"
                                  id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="remember">
                                  Keep me logged in
                                </label>
                              </div>
                              <a href="{{ route('password.request') }}" class="text-white text-decoration-underline">Forgot Password?</a>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="d-grid">
                              <button class="btn btn-primary btn-lg" type="submit">LOGIN</button>
                            </div>
                          </div>


                          {{-- <div class="col-12 mt-3">
                            <div class="d-grid">
                              <a href="#" class="btn btn-outline-light btn-lg rounded_30">
                                <img src="{{asset('images/google.png')}}" alt="Google" width="20" class="me-2">
                                Sign in with Google
                              </a>
                            </div>
                          </div> --}}

                          <div class="col-12 text-center mt-4">
                            <p class="text-white mb-0">
                              Don't have an account? 
                              <a href="{{ route('register') }}" class="text-white text-decoration-underline">Register</a>
                            </p>
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