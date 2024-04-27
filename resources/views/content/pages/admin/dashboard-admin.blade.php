@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard Admin')

@section('content')
@include('_partials.alert')
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
      <div class="col-12 col-md-8">
        <h3>Welcome back, {{ Auth::guard('admin')->user()->username }} 👋🏻 </h3>
        <div class="col-12 col-lg-7">
          <p>Access & Manage All The Functionality Of CrowdDev App !</p>
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
@endsection