@extends('layouts/layoutMaster')

@section('title', 'Management Proposal')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
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
    'resources/assets/vendor/libs/select2/select2.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/admin/manage-proposal/modal-add-proposal.js'
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
  <span class="text-muted fw-light">Management /</span> Proposal
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">Proposal Data</h5>
      <div class="d-flex align-items-center me-4">
        <button type="button" class="rounded px-4 py-2 btn btn-outline-success bg-label-success" data-bs-toggle="modal" data-bs-target="#addProposal"><i class="fa fa-plus me-3"></i> Add Data</button>
      </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Username</th>
          <th>Company</th>
          <th>Total Target</th>
          <th>Status</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($proposal as $p)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->title }}</td>
            <td>{{ $p->User->username }}</td>
            <td>{{ ($p->Company)->company_name ?? '-' }}</td>
            <td>Rp. {{ number_format($p->total_target,2,',','.') }}</td>
            <td>{{ $p->status }}</td>
            <td>
              <div class="d-flex dropdown justify-content-center">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn-edit" data-href="{{ route('management.admin.show', $p->id) }}"><i class="ti ti-pencil me-1"></i> Edit</button>
                  <button type="button" class="dropdown-item btn-delete" data-href="{{ route('management.admin.destroy', $p->id) }}"><i class="ti ti-trash me-1"></i> Delete</button>
                  <button type="button" class="dropdown-item btn-change-password" data-href="{{ route('management.admin.show.password', $p->id) }}"><i class="ti ti-key me-1"></i> Change Password</button>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@include('content.pages.admin.management.proposal.component.modal-add-proposal')
{{-- @include('content.pages.admin.management.admin.component.modal-edit-admin')
@include('content.pages.admin.management.admin.component.modal-change-password-admin') --}}

@endsection
