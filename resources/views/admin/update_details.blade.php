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

                                <form method="POST" action="{{ route('admin.update-details') }}">
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
