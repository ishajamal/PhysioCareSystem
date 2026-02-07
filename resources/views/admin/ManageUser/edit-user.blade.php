@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 mt-5">
                <div class="card-body p-5">

                    {{-- HEADER --}}
                    <div class="text-center mb-5">
                        <h2 class="mb-2">{{ $user->name }}</h2>
                        <br>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                        <span class="badge badge-primary px-4 py-2">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <br>
                    <hr class="my-5">
                    <br>
                    {{-- FORM --}}
                    <form method="POST" action="{{ route('admin.manage.user.update', $user->userID) }}">
                        @csrf

                        <div class="row g-5"> {{-- g-5 = big vertical spacing --}}

                            {{-- FULL NAME --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Full Name</label>
                                <input type="text"
                                       name="name"
                                       value="{{ $user->name }}"
                                       class="form-control form-control-lg py-3">
                            </div>
                            <br>
                            {{-- EMAIL --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Email Address</label>
                                <input type="email"
                                       name="email"
                                       value="{{ $user->email }}"
                                       class="form-control form-control-lg py-3">
                            </div>
                            <br>
                            {{-- ROLE --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Role</label>
                                <select name="role" class="form-control form-control-lg py-3">
                                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                    <option value="therapist" {{ $user->role=='therapist'?'selected':'' }}>Therapist</option>
                                    <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                                    <option value="technician" {{ $user->role=='technician'?'selected':'' }}>Technician</option>
                                    <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                                </select>
                            </div>
                            <br>
                            {{-- PASSWORD --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">
                                    Password <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg py-3"
                                       placeholder="Leave blank if no change">
                            </div>

                        </div>
                            <br>
                        <hr class="my-5">
                            <br>
                        {{-- BUTTONS --}}
                         <button class="btn btn-primary btn-lg">
                        Save Changes
                    </button>
                

                        <div class="text-center mt-4">
                    <a href="{{ route('admin.manage.user') }}" 
                    class="btn btn-secondary btn-lg mr-3">
                    Back
                    </a>
                </div>    
                   

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
