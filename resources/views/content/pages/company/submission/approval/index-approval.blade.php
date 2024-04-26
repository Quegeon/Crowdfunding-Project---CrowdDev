@extends('layouts.layoutMaster')

@section('title', 'Approval Submission')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/jquery/jquery.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
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
        <span class="text-muted fw-light">Submission /</span> Approval
    </h4>

    @include('_partials.alert')

    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">Submission</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Document</th>
                        <th>Client</th>
                        <th class="text-center">Approval</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($proposal as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->title }}</td>
                        <td>{{ $p->document }}</td>
                        <td>{{ $p->User->username }}</td>
                        <td class="text-center">
                            <a href="{{ route('company.submission.approval.approve', $p->id) }}" class="btn btn-outline-success bg-label-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"><i class="fa fa-check"></i></a>
                            <a href="{{ route('company.submission.approval.reject', $p->id) }}" class="btn btn-outline-danger bg-label-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject"><i class="fa fa-times"></i></a>              
                        </td>
                        <td>
                        <div class="d-flex dropdown justify-content-center">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a href="{{ route('company.submission.approval.download', $p->id) }}" class="dropdown-item"><i class="ti ti-download me-1"></i> Download</a>
                            </div>x
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-5">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">Ongoing</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Document</th>
                        <th>Client</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Confirmation</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($ongoing as $o)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $o->title }}</td>
                        <th>{{ $o->document }}</th>
                        <td>{{ $o->User->username }}</td>
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
                        <td class="text-center">
                            @if ($o->status == 'Ongoing')
                                <a href="{{ route('company.submission.confirmation', $o->id) }}" class="btn btn-outline-success bg-label-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm Done"><i class="fa fa-check"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection