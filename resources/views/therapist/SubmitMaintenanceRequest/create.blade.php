@extends('layouts.therapist')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* Page wrapper */
.mr-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Inter', sans-serif;
}

/* Header */
.mr-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}

.mr-title {
    font-size: 28px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    letter-spacing: -0.5px;
}

/* Back pill */
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    color: #1f2937;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.25s ease;
}
.back-btn:hover {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12), 0 8px 20px rgba(0,0,0,0.05);
    transform: translateY(-1px);
}

/* Info / Alert */
.mr-alert {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e3a8a;
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: 16px;
    font-size: 14px;
}

/* Error box */
.mr-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: 16px;
    font-size: 14px;
}

/* Card */
.mr-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
}

/* Form */
.form-label {
    font-weight: 700;
    color: #111827;
}

.form-control, .form-select, textarea {
    border-radius: 14px !important;
    border: 1px solid #e5e7eb !important;
    background: #f9fafb !important;
}
.form-control:focus, .form-select:focus, textarea:focus {
    background: #ffffff !important;
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15) !important;
}

/* Submit btn */
.submit-btn {
    padding: 10px 22px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
}
.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
}
</style>

<div class="mr-page">

    <div class="mr-header">
        <h1 class="mr-title">Add New Maintenance Request</h1>
        <a href="{{ route('therapist.maintenance.index') }}" class="back-btn">
            <span style="font-size:16px; line-height:0;">&larr;</span> Back
        </a>
    </div>

    <div class="mr-alert">
        Only <b>therapy equipment</b>, <b>exercise equipment</b> and <b>mobility aids</b> can be submitted for maintenance.
    </div>

    @if($errors->any())
        <div class="mr-error">
            <b>Please fix:</b>
            <ul class="mb-0" style="margin-top:8px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mr-error">{{ session('error') }}</div>
    @endif

    <div class="mr-card">
        <form action="{{ route('therapist.maintenance.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Equipment</label>
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
                <label class="form-label">Issue</label>
                <input type="text" name="itemIssue" class="form-control" value="{{ old('itemIssue') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Details</label>
                <textarea name="detailsMaintenance" rows="5" class="form-control" required>{{ old('detailsMaintenance') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Upload Evidence <span style="font-weight:500; color:#6b7280;">(optional)</span></label>
                <input type="file" name="images[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Max 2MB each. You can upload multiple images.</div>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>
@endsection
