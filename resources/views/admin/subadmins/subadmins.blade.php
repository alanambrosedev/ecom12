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
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subadmin->name }}</td>
                                <td>{{ $subadmin->mobile }}</td>
                                <td>{{ $subadmin->email }}</td>
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
