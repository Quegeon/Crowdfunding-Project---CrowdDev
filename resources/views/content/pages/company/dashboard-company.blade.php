@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard Company')

@section('content')
@include('_partials.alert')
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
      <div class="col-12 col-md-8">
        <h3>Welcome back, {{ Auth::guard('company')->user()->username }} 👋🏻 </h3>
        <div class="col-12 col-lg-7">
          <p>Easily Collaborate With Client To Solve Their Problem & Get Your Rewards !</p>
        </div>
        <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
          <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
            <span class="bg-label-warning p-2 rounded">
              <i class='ti ti-files ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Submission To Be Approved</p>
              <h4 class="text-warning mb-0">{{ $count_approved }}</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-success p-2 rounded">
              <i class='ti ti-discount-check ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Total Project Finished</p>
              <h4 class="text-success mb-0">{{ $count_finished }}</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-danger p-2 rounded">
              <i class='ti ti-thumb-down ti-xl'></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Total Project Rejected</p>
              <h4 class="text-danger mb-0">{{ $count_rejected }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection