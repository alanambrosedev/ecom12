@extends('admin.layout.layout')

@section('content')
    <div class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">SubadminDetails Management</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-md-6">
                        <!--begin::Card-->
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">{{ $title }}</div>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ url('admin/add-edit-subadminDetails/request') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $subadminDetails->id ?? '' }}">

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $subadminDetails->name ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $subadminDetails->email ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                        @if (!empty($subadminDetails->id))
                                            <small class="text-muted">Leave blank to keep existing password</small>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="mobile"
                                            value="{{ old('mobile', $subadminDetails->mobile ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/*">

                                        @if (!empty($subadminDetails->image))
                                            <div id="profileImageBlock" class="mt-2">
                                                <a target="_blank"
                                                    href="{{ url('admin/images/photos/' . $subadminDetails->image) }}"
                                                    class="btn btn-outline-primary btn-sm me-2">
                                                    View Image
                                                </a>
                                                <input type="hidden" name="current_image"
                                                    value="{{ $subadminDetails->image }}">
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content-->
    </div>
@endsection
