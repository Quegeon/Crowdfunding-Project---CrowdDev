@extends('layouts/layoutMaster')

@section('title', 'Login')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/app/login.js'
])
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/crowdfunding/login.png') }}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration">

        <img src="{{ asset('assets/img/crowdfunding/bg-shape-image-dark.png') }}" alt="auth-login-cover" class="platform-bg">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
  
      <div class="w-px-400 mx-auto">
        <!-- Logo -->
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible mb-5" role="alert">
          <ul>
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="app-brand mb-4">
          <a class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
          </a>
        </div>
        <!-- /Logo -->
        <h3 class=" mb-1">Welcome to CrowdDev</h3>
        <p class="mb-4">Please login to your account</p>

        <form id="formAuthentication" class="mb-3" action="{{ route('login.post') }}" method="POST" autocomplete="off">
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon11">@</span>
              <input type="text" name="email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('email') }}" aria-describedby="basic-addon11" />
            </div>
          </div>
          <div class="mb-3">
            <div class="form-password-toggle">
              <label class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" id="basic-default-password12" placeholder="Please Enter A Password" value="{{ old('password') }}" />
                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <button class="btn btn-primary d-grid w-100">
            Login
          </button>
        </form>

        <p class="text-center">
          <span>Don't have an account?</span>
          <a href="{{ route('register') }}">
            <span>Register here</span>
          </a>
        </p>

        <div class="divider my-4">
          <div class="divider-text">or</div>
        </div>

        <p class="text-center">
          <span>Want to make a new company account?</span>
          <a href="{{ route('register.company') }}">
            <span>Create here</span>
          </a>
        </p>
      </div>
    </div>
    <!-- /Login -->
  </div>
</div>
@endsection