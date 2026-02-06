@extends('layouts.app')

@section('title', 'Inventory List') 

@section('content')
<div class="container">

<h3>Edit User</h3>

<form method="POST" action="{{ route('manage.user.update', $user->id) }}">
@csrf

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
</div>

<div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-control">
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        <option value="therapist" {{ $user->role=='therapist'?'selected':'' }}>Therapist</option>
    </select>
</div>

<div class="mb-3">
    <label>Password (Optional)</label>
    <input type="password" name="password" class="form-control">
</div>

<button class="btn btn-success">Save Changes</button>
<a href="{{ route('manage.user') }}" class="btn btn-secondary">Back</a>

</form>

</div>
@endsection
