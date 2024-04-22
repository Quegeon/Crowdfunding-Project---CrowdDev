@extends('layouts/layoutMaster')

@section('title', 'Management Funding')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
  ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/admin/manage-funding/modal-add-funding.js',
        'resources/assets/js/admin/manage-funding/general-funding.js'
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
  <span class="text-muted fw-light">Management /</span> Funding
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">Funding Data</h5>
      <div class="d-flex align-items-center me-4">
        <button type="button" class="rounded px-4 py-2 btn btn-outline-success bg-label-success" data-bs-toggle="modal" data-bs-target="#addFunding"><i class="fa fa-plus me-3"></i> Add Data</button>
      </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Proposal</th>
          <th>Sponsor</th>
          <th>Fund</th>
          <th>Date</th>
          <th>Progress</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($funding as $f)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $f->Proposal->title }}</td>
            <td>{{ $f->User->username }}</td>
            <td>Rp. {{ number_format($f->fund,2,',','.') }}</td>
            <td>{{ $f->created_at->toDateString() }}</td>
            <td>Rp. {{ number_format($f->Proposal->total_funded,2,',','.') }} / Rp. {{ number_format($f->Proposal->total_target,2,',','.') }}</td>
            <td>
              @if ($f->Proposal->status == 'Funding' || $f->Proposal->status == 'Selection')
                <div class="d-flex dropdown justify-content-center">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <button type="button" class="dropdown-item btn-edit" data-href="{{ route('management.funding.show', $f->id) }}"><i class="ti ti-pencil me-1"></i> Edit</button>
                    <button type="button" class="dropdown-item btn-delete" data-href="{{ route('management.funding.destroy', $f->id) }}"><i class="ti ti-trash me-1"></i> Delete</button>
                  </div>
                </div>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@include('content.pages.admin.management.funding.component.modal-add-funding')
@include('content.pages.admin.management.funding.component.modal-edit-funding')

@endsection
