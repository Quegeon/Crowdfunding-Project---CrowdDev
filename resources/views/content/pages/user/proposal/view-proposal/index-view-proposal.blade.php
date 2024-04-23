@extends('layouts/layoutMaster')

@section('title', 'View Proposal')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
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
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/user/view-proposal/general-view-proposal.js'
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
  <span class="text-muted fw-light">Proposal /</span> View Proposal
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">Proposal</h5>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Username</th>
          <th>Document</th>
          <th>Progress</th>
          <th class="text-center">Status</th>
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
            <td>Rp. {{ number_format($p->total_funded,2,',','.') }} / Rp. {{ number_format($p->total_target,2,',','.') }}</td>
            <td class="text-center">
              <span class="badge bg-label-primary text-center">Funding</span>
            </td>
            <td>
              <div class="d-flex dropdown justify-content-center">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn-fund" data-href="{{ route('user.proposal.view-proposal.show.fund', $p->id) }}"><i class="ti ti-wallet me-1"></i> Fund</button>
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

@include('content.pages.user.proposal.view-proposal.component.modal-user-fund')

@endsection
