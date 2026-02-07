@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800" style="margin-bottom:25px;">Manage Users</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Area -->
    <form method="GET" action="{{ route('admin.manage.user') }}" style="margin-bottom:30px;">
        <div class="row align-items-center">
            <div class="col-md-7">
                <input type="text" name="search"
                       class="form-control form-control-lg"
                       placeholder="Search ID or Name"
                       value="{{ $search }}">
            </div>

            <div class="col-md-5">
                <button class="btn btn-primary btn-lg w-10000">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>
    </form>

    <!-- User Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">User List</h3>
        </div>
        <br>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle"
                       style="border:2px solid #4e73df;">

                    <thead style="background:#4e73df; color:white;">
                        <tr>
                            <th class="text-center" style="width:80px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="text-center" style="width:150px;">Role</th>
                            <th class="text-center" style="width:150px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $u)
                        <tr style="height:80px;">
                            <!-- ID CENTER -->
                            <td class="text-center py-3">{{ $u->userID }}</td>

                            <td class="py-3">{{ $u->name }}</td>
                            <td class="py-3">{{ $u->email }}</td>

                            <!-- ROLE CENTER -->
                            <td class="text-center py-3">
                                <span class="badge badge-info px-3 py-2">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>

                            <!-- ACTION CENTER -->
                            <td class="text-center py-3">
                                <a href="{{ route('admin.manage.user.edit', $u->userID) }}"
                                   class="btn btn-sm btn-warning mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.manage.user.delete', $u->userID) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this user?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
