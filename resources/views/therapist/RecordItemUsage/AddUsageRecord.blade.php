@extends('layouts.therapist')

@section('title', 'Add Usage Record')

@section('content')

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= PAGE ================= */
.page-wrapper {
    padding: 40px;
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

/* ================= HEADER ================= */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
}

/* ================= BUTTONS ================= */
.btn-back {
    background: #e5e7eb;
    color: #374151;
    border: none;
    padding: 8px 18px;
    border-radius: 999px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.25s ease;
}
.btn-back i {
    font-weight: 900;
    font-size: 14px; /* Make it bigger too */
}

.btn-back:hover {
    background: #d1d5db;
}

.btn-save {
    background: #1e40af;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 999px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(30, 64, 175, 0.25);
}

.btn-save:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
}
.btn-save i {
    font-size: 16px;
    vertical-align: middle;
    margin-right: 5px;
    color: white !important; /* Make it visible on blue button */
}


/* ================= CARD LAYOUT ================= */
.usage-card {
    display: grid;
    grid-template-columns: 2.2fr 1fr;
    gap: 25px;
}

/* ================= LEFT PANEL ================= */
.usage-left {
    background: white;
    border-radius: 18px;
    padding: 30px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
}

/* ================= RIGHT PANEL ================= */
.usage-right {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ================= FORM GRID ================= */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full {
    grid-column: span 2;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

/* ================= INPUTS ================= */
.form-control {
    padding: 11px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    background: #f9fafb;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.readonly {
    background: #f1f5f9;
    color: #6b7280;
}

/* ================= AVAILABLE TEXT ================= */
.available-text {
    font-size: 12px;
    color: #dc2626;
    margin-top: 6px;
    font-weight: 500;
}

/* ================= IMAGE ================= */
.image-box {
    border: 1px dashed #c7d2fe;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    width: 100%;
    background: #f8fafc;
}

.image-box img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
}

/* ================= FOOTER ACTIONS ================= */
.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 30px;
    gap: 12px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 1024px) {
    .usage-card {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .page-wrapper {
        padding: 20px;
    }

    .page-title {
        font-size: 22px;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }
}

/* ================= REQUIRED ASTERISK ================= */
.form-label::after {
    content: '';
}

.form-label:has(+ input[required])::after,
.form-label:has(+ .form-control[required])::after {
    content: ' *';
    color: #dc2626;
    font-weight: 700;
}

.form-label.required::after {
    content: ' *';
    color: #dc2626;
    font-weight: 700;
}
</style>


<div >
    

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Add Usage Record</h1>
        <div>
            <button class="btn-back" onclick="window.history.back()"><i class="bi bi-arrow-left"></i> Back</button>
            <button type="submit" form="usageForm" class="btn-save"><i class="bi bi-floppy"></i> Save</button>
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
                        <label class="form-label">Item ID</label>
                        <input type="text" class="form-control readonly" value="{{ $item->itemID }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control readonly" value="{{ $item->itemName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Quantity</label>
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
                        <label class="form-label required">Date Submitted</label>
                        <input type="date" 
                               name="usage_date" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="form-group full">
                        <label class="form-label required">Therapist Name</label>
                        <input type="text" 
                               name="therapist_name" 
                               class="form-control readonly" 
                               value="{{ auth()->user()->name }}" 
                               readonly>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Description</label>
                        <textarea name="notes" 
                                  class="form-control readonly" 
                                  rows="5"
                                  placeholder="Add notes here..."> {{ $item->description }}</textarea>
                    </div>

                </div>
            </form>
        </div>

       <!-- Right Side: Image -->
<div class="usage-right">
    <div class="image-box">
        @if($item->images && $item->images->count() > 0)
            <img src="{{ asset('storage/' . $item->images->first()->imagePath) }}" alt="Item Image">
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
