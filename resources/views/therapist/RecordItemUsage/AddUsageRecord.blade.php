@extends('layouts.therapist')

@section('title', 'Add Usage Record')

@section('content')

<style>
/* Page Wrapper */
.page-wrapper {
    padding: 30px;
    background: #f2f2f2;
    min-height: 100vh;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-title {
    font-size: 26px;
    font-weight: 600;
    color: #333;
}

/* Buttons */
.btn-back {
    background: #1d4ed8;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    margin-right: 10px;
}

.btn-save {
    background: #a7f3d0;
    color: #065f46;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

/* Main Card */
.usage-card {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

/* Left Panel */
.usage-left {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
}

/* Right Panel */
.usage-right {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full {
    grid-column: span 2;
}

.form-label {
    font-size: 14px;
    color: #555;
    margin-bottom: 6px;
}

.form-control {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    background: #f9fafb;
}

.form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

.readonly {
    background: #f1f5f9;
}

/* Available Text */
.available-text {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
}

/* Image Box */
.image-box {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    width: 100%;
}

.image-box img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Footer Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 25px;
    gap: 10px;
}
</style>

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Add Usage Record</h1>
        <div>
            <button class="btn-back" onclick="window.history.back()">← Back</button>
            <button type="submit" form="usageForm" class="btn-save">💾 Save</button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="usage-card">

        <!-- Left Side: Form -->
        <div class="usage-left">
            <form id="usageForm" action="{{ route('therapist.usage.store') }}" method="POST">
                @csrf

                <input type="hidden" name="item_id" value="{{ $item->itemID }}">

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">Product Code</label>
                        <input type="text" class="form-control readonly" value="{{ $item->itemID }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control readonly" value="{{ $item->itemName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Quantity *</label>
                        <input type="number" 
                               name="quantity" 
                               class="form-control" 
                               min="1" 
                               max="{{ $item->quantity }}"
                               value="1"
                               required>
                        <span class="available-text">Available: {{ $item->quantity }}</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date Submitted *</label>
                        <input type="date" 
                               name="usage_date" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Therapist Name *</label>
                        <input type="text" 
                               name="therapist_name" 
                               class="form-control readonly" 
                               value="{{ auth()->user()->name }}" 
                               readonly>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Patient Name (Optional)</label>
                        <input type="text" 
                               name="patient_name" 
                               class="form-control" 
                               placeholder="Enter patient name">
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="5"
                                  placeholder="Add notes here..."></textarea>
                    </div>

                </div>
            </form>
        </div>

        <!-- Right Side: Image -->
        <div class="usage-right">
            <div class="image-box">
                @if(!empty($item->image))
                    <img src="{{ asset('storage/'.$item->image) }}" alt="Item Image">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image">
                @endif
            </div>
        </div>

    </div>
</div>

<script>
document.querySelector('input[name="quantity"]').addEventListener('change', function() {
    const maxQuantity = {{ $item->quantity }};
    if (this.value > maxQuantity) {
        this.value = maxQuantity;
        alert('Quantity cannot exceed available stock of ' + maxQuantity);
    }
    if (this.value < 1) {
        this.value = 1;
    }
});
</script>

@endsection
