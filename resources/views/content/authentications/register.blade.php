@extends('layouts/layoutMaster')

@section('title', 'Register')

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
  'resources/assets/js/app/register.js'
])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-4 mt-2">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
              <span class="app-brand-text demo text-body fw-bold ms-1">CrowdDev</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Register New Account</h4>
          <p class="mb-4">Client & Sponsor account</p>

          <form id="formAuthentication" class="mb-3" action="{{ route('register.post') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Please Enter A Name" value="{{ old('name') }}" />
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Please Enter A Username" value="{{ old('username') }}" />
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
            <div class="mb-3">
              <label class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon11">@</span>
                <input type="text" name="email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('email') }}" aria-describedby="basic-addon11" />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Credential</label>
              <input type="text" name="payment_credential" class="form-control" placeholder="Please Enter An Payment Credential" value="{{ old('payment_credential') }}" />
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">
              Register
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">
              <span>Login instead</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection
