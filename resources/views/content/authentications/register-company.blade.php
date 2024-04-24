@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Multi Steps Sign-up - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
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
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/app/register-company.js'
])
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">

    <!-- Left Text -->
    <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 auth-cover-bg-color position-relative auth-multisteps-bg-height">
      <img src="{{ asset('assets/img/crowdfunding/login.png') }}" alt="auth-register-multisteps" class="img-fluid" width="280">

      <img src="{{ asset('assets/img/crowdfunding/bg-shape-image-dark.png') }}" alt="auth-register-multisteps" class="platform-bg">
    </div>
    <!-- /Left Text -->

    <!--  Multi Steps Registration -->
    <div class="d-flex col-lg-8 align-items-center justify-content-center p-sm-5 p-3">
      <div class="w-px-700">
        <div id="multiStepsValidation" class="bs-stepper shadow-none">
          <div class="bs-stepper-header border-bottom-0">
            <div class="step" data-target="#account-details">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-smart-home ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Account Details</span>
                </span>
              </button>
            </div>
            <div class="line">
              <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step" data-target="#company-details">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Company Details</span>
                </span>
              </button>
            </div>
            <div class="line">
              <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step" data-target="#representative-details">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-file-text ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Representative Details</span>
                </span>
              </button>
            </div>
          </div>
          <div class="bs-stepper-content">
            <form action="{{ route('register.company.post') }}" method="POST" id="multiStepsForm" onSubmit="return false" autocomplete="off">
              @csrf
              <!-- Account Details -->
              <div id="account-details" class="content">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Please Enter A Username" value="{{ old('username') }}" />
                  </div>
                  <div class="col-sm-6 form-password-toggle">
                    <label class="form-label">Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                      <span class="input-group-text cursor-pointer" id="password-modern-vertical1"><i class="ti ti-eye-off"></i></span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label">Company Email</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon11">@</span>
                      <input type="text" id="company_email" name="company_email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('company_email') }}" aria-describedby="basic-addon11" />
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
                  </div>
                </div>
              </div>
              <!-- Personal Info -->
              <div id="company-details" class="content">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control" placeholder="Please Enter A Company Name" value="{{ old('company_name') }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label">Work Fields</label>
                    <input type="text" name="work_field" class="form-control" placeholder="Please Enter Working Fields Of Company" value="{{ old('work_field') }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label">Country</label>
                    <select name="country" class="country-data">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-sm-12">
                    <label class="form-label">Company Description</label>
                    <textarea name="company_description" class="form-control" rows="5" maxlength="255" placeholder="Please Enter Company Descriptions">{{ old('company_description') }}</textarea>
                  </div>
                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                      <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
                  </div>
                </div>
              </div>
              <!-- Billing Links -->
              <div id="representative-details" class="content">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Please Enter A Name" value="{{ old('name') }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label">Position</label>
                    <input type="text" name="position" class="form-control" placeholder="Please Enter A Position" value="{{ old('position') }}" />
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label">Personal Email</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon11">@</span>
                      <input type="text" name="personal_email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('personal_email') }}" aria-describedby="basic-addon11" />
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                      <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-outline-success bg-label-success btn-submit">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- / Multi Steps Registration -->
  </div>
</div>

<script type="module">
  // Check selected custom option
  window.Helpers.initCustomOptionCheck();
</script>
@endsection
