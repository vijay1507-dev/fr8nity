@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="min-vh-100 d-flex align-items-center justify-content-center py-4 px-2 bg-black">
    <div class="container ">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5 col-xl-5">
          <div class="gradient_rounded radies_20 shadow-sm">
            <div class="card-body blacklight px-3 px-sm-4 px-md-5 py-3 py-md-4 radies_20">

              <!-- Logo -->
              <div class="text-center mb-4">
                <a href="/">
                  <img src="./images/logo (3).svg" alt="Logo" height="80" class="img-fluid">
                </a>
              </div>

              <!-- Error Display  -->
              @if ($errors->any()) 
              <div class="alert alert-danger mt-3 py-2 px-2">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              
              <form method="POST" action="{{ url('/login') }}">
                 @csrf 
                <input type="hidden" class="form-control p-2" name="is_admin" value="true">

                <div class="row gy-3">
                  <div class="col-12">
                    <label for="email" class="form-label text-white fw-medium fs-6">Email</label>
                    <input type="email" class="form-control logininput" id="email" name="email"
                      value="{{ old('email') }}" placeholder="Email Address" required>
                  </div>

                  <div class="col-12">
                    <label for="password" class="form-label text-white fw-medium fs-6">Password</label>
                    <input type="password" class="form-control logininput" id="password" name="password"
                      placeholder="Password" required>
                  </div>


                  <div class="col-12">
                    <div class="form-check d-flex justify-content-between align-items-center">
                      <div>
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1"
                          {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-white fw-medium" for="remember">
                          Remember me
                        </label>
                      </div>
                      <a href="{{ route('password.request') }}" class="text-white text-decoration-underline">
                        Forgot Password?
                      </a>
                    </div>
                  </div>


                  <div class="col-12">
                    <div class="d-flex justify-content-center mt-3">
                      <button class="btnbg w-100 py-2" type="submit">LOGIN</button>
                    </div>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection