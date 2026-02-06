@extends('layouts.app')

@section('title', 'Inventory List') 

@section('content')
<div class="container">

    <h3>Manage Users</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('manage.user') }}" class="mb-3">
        <input type="text" name="search" placeholder="Search ID or Name"
               value="{{ $search }}" class="form-control">
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    <a href="{{ route('manage.user.edit', $u->id) }}"
                       class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('manage.user.delete', $u->id) }}"
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this user?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

</div>
@endsection
