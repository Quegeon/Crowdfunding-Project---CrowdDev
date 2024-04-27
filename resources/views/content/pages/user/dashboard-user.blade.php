@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard Client & Sponsor')

@section('content')
@include('_partials.alert')
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
      <div class="col-12 col-md-8">
        <h3>Welcome back, {{ Auth::user()->username }} 👋🏻 </h3>
        <div class="col-12 col-lg-7">
          <p>Create A Brand New Proposal or Become A Sponsor To Others Proposals !</p>
        </div>
        <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
          <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
            <span class="bg-label-primary p-2 rounded">
              <i class='ti ti-files ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Proposal Created</p>
              <h4 class="text-primary mb-0">{{ $count_proposal }}</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-success p-2 rounded">
              <i class='ti ti-wallet ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Total Fund Gathered</p>
              <h4 class="text-success mb-0">Rp. {{ number_format($sum_fund) }}</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-warning p-2 rounded">
              <i class='ti ti-discount-check ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Total Ongoing Project </p>
              <h4 class="text-warning mb-0">{{ $count_ongoing }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Latest Proposal</h5>
          </div>
          <div class="card-body row g-3">
            <table class="table">
                <thead class="table-primary">
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Total Funded</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach ($latest as $l)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $l->title }}</td>
                      <td>Rp. {{ number_format($l->total_funded) }}</td>
                      <td class="text-center">
                        @switch($l->status)
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
                            @case('Done')
                                <span class="badge bg-label-secondary text-center">Done</span>
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
    
    <div class="col-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Ongoing Proposal</h5>
          </div>
          <div class="card-body row g-3">
            <table class="table">
                <thead class="table-primary">
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach ($ongoing as $o)
                    <tr>
                      <td>{{ $o->iteration }}</td>
                      <td>{{ $o->title }}</td>
                      <td>{{ $o->Company->company_name }}</td>
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

@endsection