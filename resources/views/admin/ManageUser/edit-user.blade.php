@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">

<div class="row justify-content-center">
<div class="col-lg-10">  {{-- wider container --}}

<div class="card shadow-lg border-0 mt-4">
<div class="card-body p-5">

    <!-- HEADER -->
    <div class="mb-5 text-center">
        <h2 class="mb-2">{{ $user->name }}</h2>
        <p class="text-muted">{{ $user->email }}</p>
        <span class="badge badge-primary px-4 py-2">
            {{ ucfirst($user->role) }}
        </span>
    </div>

    <hr class="mb-5">

    <form method="POST" action="{{ route('admin.manage.user.update', $user->userID) }}">
        @csrf

        <div class="row">

            <!-- NAME -->
            <div class="col-md-12 mb-4">
                <label class="font-weight-bold">Full Name</label>
                <input type="text"
                       name="name"
                       value="{{ $user->name }}"
                       class="form-control form-control-lg mt-2">
            </div>

            <!-- EMAIL -->
            <div class="col-md-12 mb-4">
                <label class="font-weight-bold">Email Address</label>
                <input type="email"
                       name="email"
                       value="{{ $user->email }}"
                       class="form-control form-control-lg mt-2">
            </div>

            <!-- ROLE -->
            <div class="col-md-12 mb-4">
                <label class="font-weight-bold">Role</label>
                <select name="role" class="form-control form-control-lg mt-2">
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="therapist" {{ $user->role=='therapist'?'selected':'' }}>Therapist</option>
                    <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                    <option value="technician" {{ $user->role=='technician'?'selected':'' }}>Technician</option>
                    <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                </select>
            </div>

            <!-- PASSWORD -->
            <div class="col-md-12 mb-5">
                <label class="font-weight-bold">Password (Optional)</label>
                <input type="password"
                       name="password"
                       class="form-control form-control-lg mt-2"
                       placeholder="Leave blank if no change">
            </div>

        </div>

        <hr class="mb-4">

        <!-- BUTTONS -->
        <div class="text-center">
            <a href="{{ route('admin.manage.user') }}"
               class="btn btn-secondary btn-lg px-5 mr-3">
               Back
            </a>

            <button class="btn btn-primary btn-lg px-5">
                Save Changes
            </button>
        </div>

    </form>

</div>
</div>

</div>
</div>

</div>
@endsection
