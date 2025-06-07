@extends('admin.layout.layout')
@section('content')
    <div class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Admin Management</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Details</li>
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
                                <div class="card-title">Update Details</div>
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

                                <form method="POST" action="{{ route('admin.update-details') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control"
                                            value="{{ auth()->guard('admin')->user()->email }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ auth()->guard('admin')->user()->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Profile Image</label>

                                        <!-- File input for new image -->
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/*">

                                        <!-- Existing image display and controls -->
                                        @if (!empty(Auth::guard('admin')->user()->image))
                                            <div id="profileImageBlock" class="mt-2">
                                                <a target="_blank"
                                                    href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}"
                                                    class="btn btn-outline-primary btn-sm me-2">
                                                    View Image
                                                </a>

                                                <!-- Hidden input to retain current image if new one is not uploaded -->
                                                <input type="hidden" name="current_image"
                                                    value="{{ Auth::guard('admin')->user()->image }}">

                                                <!-- Delete link (can be handled via JavaScript) -->
                                                <a href="javascript:void(0);" id="deleteProfileImage"
                                                    data-admin-id="{{ Auth::guard('admin')->user()->id }}"
                                                    class="btn btn-outline-danger btn-sm">
                                                    Delete
                                                </a>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="mobile"
                                            value="{{ auth()->guard('admin')->user()->mobile }}">
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
