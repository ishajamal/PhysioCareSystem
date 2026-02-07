@extends('layouts.therapist')

@section('title', 'Item Details')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
    font-size: 14px;
}

.btn-back:hover {
    background: #d1d5db;
}

/* ================= CARD LAYOUT ================= */
.details-card {
    display: grid;
    grid-template-columns: 2.2fr 1fr;
    gap: 25px;
}

/* ================= LEFT PANEL ================= */
.details-left {
    background: white;
    border-radius: 18px;
    padding: 30px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
}

/* ================= RIGHT PANEL ================= */
.details-right {
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

/* ================= INFO GRID ================= */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.info-group {
    display: flex;
    flex-direction: column;
}

.info-group.full {
    grid-column: span 2;
}

.info-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.info-value {
    padding: 11px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    background: #f1f5f9;
    color: #111827;
    font-weight: 500;
}

.info-value.description {
    min-height: 120px;
    white-space: pre-wrap;
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

/* ================= RESPONSIVE ================= */
@media (max-width: 1024px) {
    .details-card {
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

    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div >

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Item Details</h1>
        <div>
            <button class="btn-back" onclick="window.location.href='{{ route('therapist.view.history.details', $itemUsage->usageID) }}'">
                <i class="bi bi-arrow-left"></i> Back
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="details-card">

        <!-- Left Side: Details -->
        <div class="details-left">
            <div class="info-grid">

                <div class="info-group">
                    <label class="info-label">Product Code</label>
                    <div class="info-value">
                        ITM-{{ str_pad($itemUsage->itemMaintenanceInfo->itemID, 3, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div class="info-group">
                    <label class="info-label">Product Name</label>
                    <div class="info-value">{{ $itemUsage->itemMaintenanceInfo->itemName }}</div>
                </div>

                <div class="info-group">
                    <label class="info-label">Category</label>
                    <div class="info-value">{{ $itemUsage->itemMaintenanceInfo->category }}</div>
                </div>

                <div class="info-group">
                    <label class="info-label">Quantity Used</label>
                    <div class="info-value">{{ $itemUsage->quantityUsed }}</div>
                </div>

                <div class="info-group">
                    <label class="info-label">Date Submitted</label>
                    <div class="info-value">
                        {{ $itemUsage->usageRecord?->usageDate?->format('Y-m-d') ?? '-' }}
                    </div>
                </div>

                <div class="info-group">
                    <label class="info-label">Therapist Name</label>
                    <div class="info-value">
                        {{ $itemUsage->usageRecord?->usedByUser?->name ?? '-' }}
                    </div>
                </div>

                <div class="info-group full">
                    <label class="info-label">Description</label>
                    <div class="info-value description">{{ $itemUsage->itemMaintenanceInfo->description }}</div>
                </div>

            </div>
        </div>

        <!-- Right Side: Image -->
        <div class="details-right">
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

@endsection
