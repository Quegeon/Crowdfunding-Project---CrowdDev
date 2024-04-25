@extends('layouts/layoutMaster')

@section('title', 'My Proposal')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss'
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
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.js'
  ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/user/my-proposal/modal-my-add-proposal.js',
        'resources/assets/js/user/my-proposal/general-my-proposal.js'
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
  <span class="text-muted fw-light">Proposal /</span> My Proposal
</h4>

@include('_partials.alert')

<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">My Proposal</h5>
      <div class="d-flex align-items-center me-4">
        <button type="button" class="rounded px-4 py-2 btn btn-outline-success bg-label-success" data-bs-toggle="modal" data-bs-target="#addProposal"><i class="fa fa-plus me-3"></i> Add Proposal</button>
    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table datatable">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Document</th>
          <th>Company</th>
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
            <td>{{ $p->document }}</td>
            <td>{{ ($p->Company)->company_name ?? '-' }}</td>
            <td>Rp. {{ number_format($p->total_funded,2,',','.') }} / Rp. {{ number_format($p->total_target,2,',','.') }}</td>
            <td class="text-center">
                @switch($p->status)
                    @case('Funding')
                        <span class="badge bg-label-primary text-center">Funding</span>
                        @break
                    @case('Selection')
                        <span class="badge bg-label-info text-center">Selection</span>
                        @break
                    @case('Voting')
                        <span class="badge bg-label-dark text-center">Voting</span>
                        @break
                    @case('Approval')
                        <span class="badge bg-label-warning text-center">Approval</span>
                        @break
                    @case('Ongoing')
                        <span class="badge bg-label-success text-center">Ongoing</span>
                        @break
                    @case('Confirmation')
                        <span class="badge bg-label-warning text-center">Confirmation</span>
                        @break
                    @case('Done')
                        <span class="badge bg-label-secondary text-center">Done</span>
                        @break
                @endswitch
              </td>
            <td>
              <div class="d-flex dropdown justify-content-center">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                    <button type="button" class="dropdown-item btn-detail" data-href="{{ route('user.proposal.my-proposal.detail', $p->id) }}"><i class="ti ti-search me-1"></i> Detail</button>
                    @if ($p->status == 'Funding')
                        <button type="button" class="dropdown-item btn-fund" data-href="{{ route('user.proposal.my-proposal.show.fund', ['id' => $p->id, 'is_view_proposal' => false]) }}"><i class="ti ti-wallet me-1"></i> Fund</button>
                    @endif
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@include('content.pages.user.proposal.my-proposal.component.modal-my-add-proposal')
@include('content.pages.user.proposal.my-proposal.component.modal-my-detail-proposal')

@endsection
