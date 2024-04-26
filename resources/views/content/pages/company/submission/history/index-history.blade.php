@extends('layouts.layoutMaster')

@section('title', 'History Submission')

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
                        <th>Total Target</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($done as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->title }}</td>
                        <td>{{ $d->User->username }}</td>
                        <td>{{ $d->document }}</td>
                        <td>Rp. {{ number_format($d->total_target,2,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection