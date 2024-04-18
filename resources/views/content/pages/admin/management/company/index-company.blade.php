@extends('layouts.layoutMaster')

@section('title', 'Management Company')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
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
        'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
    ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/admin/manage-company/wizard-add-company.js',
        'resources/assets/js/admin/manage-company/general-company.js'
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
        <span class="text-muted fw-light">Management /</span> Company
    </h4>

    @include('_partials.alert')

    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">Company Data</h5>
            <div class="d-flex align-items-center me-4">
                <button type="button" class="rounded px-4 py-2 btn btn-outline-success bg-label-success" data-bs-toggle="modal" data-bs-target="#addCompany"><i class="fa fa-plus me-3"></i> Add Data</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Username</th>
                        <th>Company Email</th>
                        <th>Representative</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($company as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $c->company_name }}</td>
                        <td>{{ $c->username }}</td>
                        <td>{{ $c->company_email }}</td>
                        <td>{{ $c->name }}</td>
                        <td>
                            <div class="d-flex dropdown justify-content-center">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item btn-detail" data-href="{{ route('management.company.detail', $c->id) }}"><i class="ti ti-search me-1"></i> Detail</button>
                                    <button type="button" class="dropdown-item btn-edit" data-href="{{ route('management.company.show', $c->id) }}"><i class="ti ti-pencil me-1"></i> Edit</button>
                                    <button type="button" class="dropdown-item btn-delete" data-href="{{ route('management.company.destroy', $c->id) }}"><i class="ti ti-trash me-1"></i> Delete</button>
                                    <button type="button" class="dropdown-item btn-change-password" data-href="{{ route('management.company.show.password', $c->id) }}"><i class="ti ti-key me-1"></i> Change Password</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('content.pages.admin.management.company.component.modal-add-company')
    @include('content.pages.admin.management.company.component.modal-detail-company')
    @include('content.pages.admin.management.company.component.modal-edit-company')
    @include('content.pages.admin.management.company.component.modal-change-password-company')

@endsection