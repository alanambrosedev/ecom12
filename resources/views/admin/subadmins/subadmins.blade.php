@extends('admin.layout.layout')

@section('content')
    <main class="app-main">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Subadmins</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subAdmins as $subadmin)
                            <tr id="subadmin-row-{{ $subadmin->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subadmin->name }}</td>
                                <td>{{ $subadmin->mobile }}</td>
                                <td>{{ $subadmin->email }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="text-decoration-none updateSubadminStatus me-2"
                                        data-id="{{ $subadmin->id }}" title="Toggle Status">
                                        @if ($subadmin->status == 1)
                                            <i class="fas fa-toggle-on text-success fa-lg"></i>
                                        @else
                                            <i class="fas fa-toggle-off text-danger fa-lg"></i>
                                        @endif
                                    </a>

                                    <a href="javascript:void(0);" class="deleteSubadmin text-danger"
                                        data-id="{{ $subadmin->id }}" title="Delete Subadmin">
                                        <i class="fas fa-trash-alt fa-lg"></i>
                                    </a>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Sub Admins Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
