@extends('layouts.therapist')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* Page wrapper */
.item-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Inter', sans-serif;
}

/* Back button */
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
    box-shadow:
        0 0 0 3px rgba(37, 99, 235, 0.12),
        0 8px 20px rgba(0,0,0,0.05);
    transform: translateY(-1px);
    color: #1f2937;
}

/* Card */
.item-card {
    margin-top: 18px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow:
        0 10px 30px rgba(0,0,0,0.08),
        0 1px 4px rgba(0,0,0,0.04);
    overflow: hidden;
}

.item-card-header {
    padding: 26px 28px;
    border-bottom: 1px solid #eef2ff;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.item-title {
    font-size: 26px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    letter-spacing: -0.5px;
}

.item-subtitle {
    color: #6b7280;
    font-size: 14px;
}

/* Content layout */
.item-card-body {
    padding: 26px 28px 30px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 26px;
}

@media (max-width: 900px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}

/* Info list */
.info-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px 18px;
    margin-bottom: 18px;
}

@media (max-width: 600px) {
    .info-list {
        grid-template-columns: 1fr;
    }
}

.info-item {
    background: #f9fafb;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    padding: 14px 16px;
}

.info-label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 6px;
    font-weight: 700;
}

.info-value {
    font-size: 14px;
    color: #111827;
    font-weight: 600;
    text-transform: capitalize;
}

/* Description */
.desc-box {
    margin-top: 14px;
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    padding: 16px;
}

.desc-title {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 8px;
    font-weight: 800;
}

.desc-text {
    margin: 0;
    color: #374151;
    font-size: 14px;
    line-height: 1.6;
}

/* Status badge */
.status-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
    display: inline-block;
    text-transform: capitalize;
}

.status-available { background: #ecfdf5; color: #059669; }
.status-low { background: #fffbeb; color: #d97706; }
.status-out { background: #fef2f2; color: #dc2626; }
.status-neutral { background: #f3f4f6; color: #374151; }

/* Images */
.images-box {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    padding: 16px;
    height: fit-content;
}

.images-title {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 12px;
    font-weight: 800;
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

.image-grid a {
    display: block;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #eef2ff;
    background: #f9fafb;
    transition: all 0.2s ease;
}

.image-grid a:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

.image-grid img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
}

.no-image {
    color: #6b7280;
    font-style: italic;
    font-size: 14px;
    padding: 12px 0 2px;
}
</style>

@php
    // status badge mapping
    $s = strtolower(trim($item->status ?? ''));
    $statusClass = 'status-neutral';
    if (in_array($s, ['available'])) $statusClass = 'status-available';
    elseif (in_array($s, ['low'])) $statusClass = 'status-low';
    elseif (in_array($s, ['out', 'unavailable', 'not available'])) $statusClass = 'status-out';
@endphp

<div class="item-page">

    <a href="{{ route('therapist.items.index') }}" class="back-btn">
        <span style="font-size:16px; line-height:0;">&larr;</span>
        Back to Item List
    </a>

    <div class="item-card">
        <div class="item-card-header">
            <h1 class="item-title">{{ $item->itemName }}</h1>
            <div class="item-subtitle">Item ID: <strong>{{ $item->itemID }}</strong></div>
        </div>

        <div class="item-card-body">
            <div class="info-grid">

                <!-- LEFT: DETAILS -->
                <div>
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">Category</div>
                            <div class="info-value">{{ $item->category }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value" style="text-transform:none;">
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Condition</div>
                            <div class="info-value">{{ $item->condition }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Quantity</div>
                            <div class="info-value" style="text-transform:none;">{{ $item->quantity }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Stock Level</div>
                            <div class="info-value">{{ $item->stockLevel }}</div>
                        </div>
                    </div>

                    <div class="desc-box">
                        <div class="desc-title">Description</div>
                        <p class="desc-text">
                            {{ $item->description ?: 'No description provided.' }}
                        </p>
                    </div>
                </div>

                <!-- RIGHT: IMAGES -->
                <div class="images-box">
                    <div class="images-title">Images</div>

                    @if($item->images && $item->images->count())
                        <div class="image-grid">
                            @foreach($item->images as $img)
                                <a href="{{ asset($img->imagePath) }}" target="_blank" rel="noopener">
                                    <img src="{{ asset($img->imagePath) }}" alt="Item image">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="no-image">No image uploaded.</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
