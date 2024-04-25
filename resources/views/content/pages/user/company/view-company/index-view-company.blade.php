@extends('layouts/layoutMaster')

@section('title', 'View Company')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
    'resources/assets/vendor/libs/select2/select2.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
    'resources/assets/vendor/libs/select2/select2.js'
  ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/user/view-company/general-view-company.js'
    ])
@endsection

@section('content')
<style>
    .dropdown-item:hover {
        background-color: #f0eef2;
        color: #46285d;
    }
</style>

<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Company /</span> View Company
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">View Company</h5>
      <div class="d-flex align-items-center me-4">
    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table datatable">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Company Email</th>
                <th>Work Field</th>
                <th>Representative</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($company as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $c->company_name }}</td>
                <td>{{ $c->company_email }}</td>
                <td>{{ $c->work_field }}</td>
                <td>{{ $c->name }}</td>
                <td>
                    <div class="d-flex dropdown justify-content-center">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item btn-detail" data-href="{{ route('user.company.view-company.detail', $c->id) }}"><i class="ti ti-search me-1"></i> Detail</button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>

@include('content.pages.user.company.view-company.component.modal-detail-company')

@endsection
