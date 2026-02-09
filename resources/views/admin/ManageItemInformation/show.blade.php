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
    letter-spacing: -0.5px;
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
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 14px;
}

.btn-secondary {
    background: #f3f4f6;
    color: #111827;
}
.btn-secondary:hover { background: #e5e7eb; }

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

.details-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.details-table tr {
    border-bottom: 1px solid #eef2f7;
}

.details-table td {
    padding: 12px 10px;
    vertical-align: top;
}

.details-table td:first-child {
    width: 180px;
    font-size: 11px;
    font-weight: 800;
    color: #6b7280;
    letter-spacing: 0.6px;
    text-transform: uppercase;
}

.badge-pill {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

.badge-green { background: #ecfdf5; color: #059669; }
.badge-blue  { background: #e0f2fe; color: #0369a1; }

.image-box {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.small-note {
    font-size: 12px;
    color: #6b7280;
    margin-top: 8px;
}

@media (max-width: 900px) {
    .content-grid { grid-template-columns: 1fr; }
}
</style>

<div class="main-content-view">
    <div class="header-title-wrapper">
        <h1 class="maintenance-title">Inventory Item Details</h1>

        <a href="{{ route('admin.inventory.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="content-grid">
        <!-- LEFT: DETAILS -->
        <div class="card-box">
            <div class="card-title">Item / Equipment Information</div>

            <table class="details-table">
                <tr><td>ID</td><td>{{ $item->itemID }}</td></tr>
                <tr><td>Item Name</td><td>{{ $item->itemName ?? $item->itemCode ?? '-' }}</td></tr>
                <tr>
                    <td>Category</td>
                    <td>
                        @if(strtolower($item->category ?? '') === 'item')
                            <span class="badge-pill badge-green">Item</span>
                        @else
                            <span class="badge-pill badge-blue">Equipment</span>
                        @endif
                    </td>
                </tr>
                <tr><td>Status</td><td>{{ $item->status ?? '-' }}</td></tr>
                <tr><td>Quantity</td><td>{{ $item->quantity ?? '-' }}</td></tr>
                <tr><td>Stock Level</td><td>{{ $item->stockLevel ?? '-' }}</td></tr>
                <tr><td>Condition</td><td>{{ $item->condition ?? '-' }}</td></tr>
                <tr><td>Category</td><td>{{ $item->category ?? '-' }}</td></tr> 
                <tr><td>Description</td><td>{{ $item->description ?? '-' }}</td></tr>
                <tr><td>Created At</td><td>{{ $item->created_at ?? '-' }}</td></tr>
                <tr><td>Updated At</td><td>{{ $item->updated_at ?? '-' }}</td></tr>
            </table>
        </div>

        <!-- RIGHT: IMAGE -->
        <div class="card-box">
            <div class="card-title">Item / Equipment Image</div>

            <div class="image-box">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="Item Image">
                @else
                    <div class="small-note">No image available</div>
                @endif
            </div>

            <div class="small-note">
                Uploaded images are stored in storage/app/public.
            </div>
        </div>
    </div>
</div>
@endsection
