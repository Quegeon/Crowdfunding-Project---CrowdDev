@extends('layouts.layoutMaster')

@section('title', 'Management User')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/jquery/jquery.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'  
    ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/admin/manage-user/modal-add-user.js',
        'resources/assets/js/admin/manage-user/general-user.js'
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
        <span class="text-muted fw-light">Management /</span> User
    </h4>

    @include('_partials.alert')

    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">User Data</h5>
            <div class="d-flex align-items-center me-4">
                <button type="button" class="rounded px-4 py-2 btn btn-outline-success bg-label-success" data-bs-toggle="modal" data-bs-target="#addUser"><i class="fa fa-plus me-3"></i> Add Data</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($user as $u)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                        <div class="d-flex dropdown justify-content-center">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                            <button type="button" class="dropdown-item btn-edit" data-href="{{ route('management.user.show', $u->id) }}"><i class="ti ti-pencil me-1"></i> Edit</button>
                            <button type="button" class="dropdown-item btn-delete" data-href="{{ route('management.user.destroy', $u->id) }}"><i class="ti ti-trash me-1"></i> Delete</button>
                            <button type="button" class="dropdown-item btn-change-password" data-href="{{ route('management.user.show.password', $u->id) }}"><i class="ti ti-key me-1"></i> Change Password</button>
                            </div>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('content.pages.admin.management.user.component.modal-add-user')
    @include('content.pages.admin.management.user.component.modal-edit-user')

@endsection