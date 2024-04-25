@extends('layouts/layoutMaster')

@section('title', 'Select Company')

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
@endsection

@section('content')
<style>
    .dropdown-item:hover {
        background-color: #f0eef2;
        color: #46285d;
    }
</style>

<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Company /</span> Select Company
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">Active Vote</h5>
      <div class="d-flex align-items-center me-4">
    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table datatable">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Username</th>
            <th>Document</th>
            <th class="text-center">Vote</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($proposal as $p)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $p->title }}</td>
              <td>{{ $p->User->username }}</td>
              <td>{{ $p->document }}</td>
              <td class="text-center">
                <a href="{{ route('user.company.selection.vote.approve', $p->id) }}" class="btn btn-outline-success bg-label-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"><i class="fa fa-check"></i></a>
                <a href="{{ route('user.company.selection.vote.reject', $p->id) }}" class="btn btn-outline-danger bg-label-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject"><i class="fa fa-times"></i></a>  
              </td>  
              <td>
                <div class="d-flex dropdown justify-content-center">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <button type="button" class="dropdown-item btn-fund" data-href="{{ route('user.proposal.view-proposal.show.fund', ['id' => $p->id, 'is_view_proposal' => true]) }}"><i class="ti ti-wallet me-1"></i> Fund</button>
                    <a href="{{ route('user.proposal.view-proposal.download', $p->id) }}" class="dropdown-item"><i class="ti ti-download me-1"></i> Download</a>
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
