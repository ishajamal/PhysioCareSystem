@extends('layouts.app')

@section('title', 'Inventory Item Details')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

.main-content-view {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
}

.header-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.maintenance-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    text-decoration: none;
    font-size: 14px;
    background: #f3f4f6;
    color: #111827;
}
.btn:hover { background: #e5e7eb; }

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1.2fr;
    gap: 20px;
}

.card-box {
    background: white;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
}

.card-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 14px;
}

.details-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eef2f7;
    gap: 14px;
}
.details-row:last-child { border-bottom: none; }

.label {
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    min-width: 140px;
}
.value {
    font-size: 14px;
    color: #111827;
    text-align: right;
    flex: 1;
}

.image-box {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.image-box img { width:100%; height:100%; object-fit: contain; }

.small-note { font-size:12px; color:#6b7280; margin-top:8px; }

@media (max-width: 900px) {
    .content-grid { grid-template-columns: 1fr; }
    .value { text-align: left; }
}
</style>

<div class="main-content-view">
    <div class="header-title-wrapper">
        <h1 class="maintenance-title">Inventory Item Details</h1>

        <a href="{{ route('admin.inventory.dashboard') }}" class="btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="content-grid">
        <div class="card-box">
            <div class="card-title">Item / Equipment Information</div>

            <div class="details-row"><div class="label">ID</div><div class="value">{{ $item->itemID }}</div></div>
            <div class="details-row"><div class="label">Name</div><div class="value">{{ $item->itemName }}</div></div>
            <div class="details-row"><div class="label">Category</div><div class="value">{{ $item->category }}</div></div>
            <div class="details-row"><div class="label">Status</div><div class="value">{{ $item->status }}</div></div>

            @if(strtolower($item->category) === 'item')
                <div class="details-row"><div class="label">Quantity</div><div class="value">{{ $item->quantity }}</div></div>
                <div class="details-row"><div class="label">Stock Level</div><div class="value">{{ $item->stockLevel }}</div></div>
            @else
                <div class="details-row"><div class="label">Condition</div><div class="value">{{ $item->condition }}</div></div>
            @endif

            <div class="details-row"><div class="label">Description</div><div class="value">{{ $item->description ?? '-' }}</div></div>

            <div class="info-row">
                <span class="label">CREATED AT</span>
                <span class="value">
                    {{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">UPDATED AT</span>
                <span class="value">
                    {{ $item->updated_at ? $item->updated_at->format('d M Y, h:i A') : '-' }}
                </span>
            </div>

        </div>

        <div class="card-box">
            <div class="card-title">Item / Equipment Image</div>

            <div class="image-box">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="Item Image">
                @else
                    <div class="small-note">No image available</div>
                @endif
            </div>

            <div class="small-note">Uploaded images are stored in storage/app/public.</div>
        </div>
    </div>
</div>
@endsection
