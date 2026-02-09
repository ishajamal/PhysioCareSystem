@extends('layouts.therapist')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Add New Maintenance Request</h2>
        <a href="{{ route('therapist.maintenance.index') }}" class="text-decoration-none">&larr; Back</a>
    </div>

    <div class="alert alert-info">
        Only <b>therapy equipment</b>, <b>exercise equipment</b> and <b>mobility aids</b> can be submitted for maintenance.
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <b>Please fix:</b>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('therapist.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><b>Equipment</b></label>
                    <select name="itemID" class="form-select" required>
                        <option value="">-- Select equipment --</option>
                        @foreach($items as $it)
                            <option value="{{ $it->itemID }}"
                                {{ old('itemID', $selectedItemID) == $it->itemID ? 'selected' : '' }}>
                                {{ $it->itemName }} ({{ $it->category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Issue</b></label>
                    <input type="text" name="itemIssue" class="form-control" value="{{ old('itemIssue') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Details</b></label>
                    <textarea name="detailsMaintenance" rows="5" class="form-control" required>{{ old('detailsMaintenance') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Upload Evidence</b> (optional)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.webp">
                    <div class="form-text">Max 2MB each. You can upload multiple images.</div>
                </div>

                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
