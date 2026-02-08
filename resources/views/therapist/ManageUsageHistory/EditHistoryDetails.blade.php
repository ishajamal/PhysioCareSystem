@extends('layouts.therapist')

@section('title', 'Edit Usage Record')

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
}

.btn-save {
    background: #1e40af;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
}

/* ================= CARD LAYOUT ================= */
.usage-card {
    display: grid;
    grid-template-columns: 2.2fr 1fr;
    gap: 25px;
}

/* ================= PANELS ================= */
.usage-left,
.usage-right {
    background: white;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.usage-right {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ================= FORM ================= */
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
    margin-bottom: 6px;
}

.form-control {
    padding: 11px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #f9fafb;
}

.readonly {
    background: #f1f5f9;
    color: #6b7280;
}

.available-text {
    font-size: 12px;
    color: #dc2626;
    margin-top: 6px;
}

/* ================= IMAGE ================= */
.image-box {
    border: 1px dashed #c7d2fe;
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    text-align: center;
    background: #f8fafc;
}

.image-box img {
    max-width: 100%;
    border-radius: 12px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 1024px) {
    .usage-card { grid-template-columns: 1fr; }
}
</style>

<div >

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Edit Usage Record</h1>
        <div>
            <button class="btn-back" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </button>
            <button type="submit" form="editUsageForm" class="btn-save">
                <i class="bi bi-floppy"></i> Save
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="usage-card">

        <!-- LEFT -->
        <div class="usage-left">
            <form id="editUsageForm" 
                  action="{{ route('therapist.usage.update', [$itemUsage->usageID, $itemUsage->itemID]) }}" 
                  method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">Item ID</label>
                        <input type="text" class="form-control readonly" 
                               value="ITM-{{ str_pad($itemUsage->itemMaintenanceInfo->itemID, 3, '0', STR_PAD_LEFT) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control readonly" 
                               value="{{ $itemUsage->itemMaintenanceInfo->itemName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Quantity</label>
                        <input type="number" name="quantity" 
                               class="form-control" 
                               min="1" 
                               max="{{ $itemUsage->itemMaintenanceInfo->quantity }}" 
                               value="{{ $itemUsage->quantityUsed }}" 
                               required>
                        <span class="available-text">Available: {{ $itemUsage->itemMaintenanceInfo->quantity }}</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Date Submitted</label>
                        <input type="date" name="usage_date" 
                               class="form-control" 
                               value="{{ $itemUsage->usageRecord?->usageDate?->format('Y-m-d') }}" 
                               required>
                    </div>

                    <div class="form-group full">
                        <label class="form-label required">Therapist Name</label>
                        <input type="text" class="form-control readonly" 
                               value="{{ $itemUsage->usageRecord?->usedByUser?->name }}" readonly>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Description</label>
                        <textarea name="notes" class="form-control" rows="5">{{ $itemUsage->itemMaintenanceInfo->description }}</textarea>
                    </div>

                </div>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="usage-right">
            <div class="image-box">
                @if($itemUsage->itemMaintenanceInfo->images && $itemUsage->itemMaintenanceInfo->images->count() > 0)
                    <img src="{{ asset('storage/' . $itemUsage->itemMaintenanceInfo->images->first()->imagePath) }}" alt="Item Image">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image">
                @endif
            </div>
        </div>

    </div>
</div>

<script>
document.querySelector('input[name="quantity"]').addEventListener('change', function() {
    const maxQuantity = {{ $itemUsage->itemMaintenanceInfo->quantity }};
    if (this.value > maxQuantity) this.value = maxQuantity;
    if (this.value < 1) this.value = 1;
});
</script>

@endsection
