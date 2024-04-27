@extends('layouts.layoutMaster')

@section('title', 'History Submission')

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
        'resources/assets/js/company/history/general-history.js'
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
        <span class="text-muted fw-light">Submission /</span> History
    </h4>

    @include('_partials.alert')

    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">History</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Document</th>
                        <th class="text-center">Approval</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($history as $h)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $h->Company->title }}</td>
                        <td>{{ $h->Company->User->username }}</td>
                        <td>{{ $h->Company->document }}</td>
                        <td class="text-center">
                            <span class="badge bg-label-danger text-center">Rejected</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection