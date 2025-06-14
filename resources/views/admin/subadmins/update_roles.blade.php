@extends('admin.layout.layout')

@section('content')
    <div class="app-main">
        <!-- Page Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Subadmin Access Management</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Set Permissions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Form -->
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Permissions for: <strong>{{ $admin->name }}</strong></h4>
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
                    <form method="POST" action="{{ url('admin/update-role/' . $admin->id) }}">
                        @csrf
                        <!-- Example module block -->
                        @foreach ($modules as $module)
                            @php $role = $adminRoles[$module] ?? null; @endphp

                            <div class="mb-3 border p-3 rounded shadow-sm">
                                <h5 class="mb-2">{{ str_replace('_', ' ', $module) }}</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        name="modules[{{ $module }}][view_access]"
                                        {{ $role && $role->view_access ? 'checked' : '' }}>
                                    <label class="form-check-label">View Access</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        name="modules[{{ $module }}][edit_access]"
                                        {{ $role && $role->edit_access ? 'checked' : '' }}>
                                    <label class="form-check-label">View/Edit Access</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        name="modules[{{ $module }}][full_access]"
                                        {{ $role && $role->full_access ? 'checked' : '' }}>
                                    <label class="form-check-label">Full Access</label>
                                </div>
                            </div>
                        @endforeach
                        <!-- Submit Buttons -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Update Permissions</button>
                            <a href="{{ route('admin.subadmins') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
