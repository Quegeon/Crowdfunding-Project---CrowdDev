@extends('layouts/layoutMaster')

@section('title', 'User Profile - Profile')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  ])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  ])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite([
    'resources/assets/js/company/profile/general-profile.js'
  ])
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Company Profile</span> 
</h4>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="user-profile-header-banner">
        <img src="{{ asset('assets/img/crowdfunding/banner.png') }}" alt="Banner image" class="rounded-top">
      </div>
      <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
          <img src="{{ asset('assets/img/crowdfunding/user-bg.png') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
        </div>
        <div class="flex-grow-1 mt-3 mt-sm-5">
          <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
            <div class="user-profile-info">
              <h4>{{ Auth::guard('company')->user()->username }}</h4>
              <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <h6>{{ Auth::guard('company')->user()->name }}</h6>
              </ul>
            </div>
            <button type="button" class="px-4 py-2 btn btn-primary btn-edit" data-href="{{ route('company.profile.show') }}"><i class='ti ti-pencil me-1'></i>Edit Profile</button>              
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
      <li class="nav-item"><a class="nav-link active" href="#"><i class='ti-xs ti ti-user-check me-1'></i> Profile</a></li>
    </ul>
  </div>
</div>

@include('_partials.alert')

<div class="row">
  <div class="col-xl-4 col-lg-5 col-md-5">
    <div class="card mb-4">
      <div class="card-body">
        <small class="card-text text-uppercase">About</small>
        <ul class="list-unstyled mb-4 mt-3">
          <li class="d-flex align-items-center mb-3"><i class="ti ti-user"></i><span class="fw-medium mx-2">Name:</span> <span>{{ Auth::guard('company')->user()->name }}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-medal"></i><span class="fw-medium mx-2">Position:</span> <span>{{ Auth::guard('company')->user()->position }}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span class="fw-medium mx-2">Email:</span> <span>{{ Auth::guard('company')->user()->personal_email }}</span></li>
        </ul>
        <small class="card-text text-uppercase">Company Details</small>
        <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-briefcase"></i><span class="fw-medium mx-2">Name:</span> <span>{{ Auth::guard('company')->user()->company_name }}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span class="fw-medium mx-2">Email:</span> <span>{{ Auth::guard('company')->user()->company_email }}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-star"></i><span class="fw-medium mx-2">Work Field:</span> <span>{{ Auth::guard('company')->user()->work_field }}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-flag"></i><span class="fw-medium mx-2">Country:</span> <span>{{ Auth::guard('company')->user()->country }}</span></li>
        </ul>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-body">
        <p class="card-text text-uppercase">Overview</p>
        <ul class="list-unstyled mb-0">
          <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span class="fw-medium mx-2">Project Finished:</span> <span>{{ $finished->count() }}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-clock"></i><span class="fw-medium mx-2">Project Ongoing:</span> <span>{{ $ongoing->count() }}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-thumb-down"></i><span class="fw-medium mx-2">Project Rejected:</span> <span>{{ $rejected->count() }}</span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-7 col-md-7">
    <div class="card card-action mb-4">
      <div class="card-header align-items-center">
        <h5 class="card-action-title mb-0">Ongoing Project</h5>
      </div>
      <div class="card-body pb-0">
        <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Username</th>
                  <th>Document</th>
                  <th>Company</th>
                  <th>Total Target</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($ongoing as $o)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $o->title }}</td>
                    <td>{{ $o->User->username }}</td>
                    <td>{{ $o->document }}</td>
                    <td>{{ ($o->Company)->company_name ?? '-' }}</td>
                    <td>Rp. {{ number_format($o->total_target,2,',','.') }}</td>
                    <td class="text-center">
                      @switch($o->status)
                          @case('Ongoing')
                              <span class="badge bg-label-success text-center">Ongoing</span>
                              @break
                          @case('Confirmation')
                              <span class="badge bg-label-warning text-center">Confirmation</span>
                              @break
                      @endswitch
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>

@include('content.pages.company.profile.component.modal-edit-profile')

@endsection
