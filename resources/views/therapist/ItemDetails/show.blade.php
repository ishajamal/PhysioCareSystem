@extends('layouts.therapist') 

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.item-container{
    max-width: 1200px;
    margin: 0 auto;
    padding: 34px 20px;
    font-family: 'Inter', sans-serif;
}

.back-btn{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #111827;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: all .2s ease;
    margin-bottom: 18px;
}
.back-btn:hover{
    border-color:#2563eb;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.15);
    transform: translateY(-1px);
}

.card-wrap{
    background: #fff;
    border-radius: 18px;
    padding: 22px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
}

.item-title{
    font-size: 30px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    letter-spacing: -0.4px;
}

.item-sub{
    margin-top: 6px;
    color: #6b7280;
    font-weight: 500;
}

.grid{
    display: grid;
    grid-template-columns: 1fr 1fr 1.3fr;
    gap: 16px;
    margin-top: 18px;
}

.info-box{
    border: 1px solid #eef2ff;
    background: #f9fafb;
    border-radius: 14px;
    padding: 14px 16px;
}

.info-label{
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    color: #6b7280;
    margin-bottom: 6px;
}
.info-value{
    font-size: 14px;
    font-weight: 700;
    color: #111827;
}

.status-badge{
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
    display: inline-block;
}
.status-available { background: #ecfdf5; color: #059669; }
.status-low { background: #fffbeb; color: #d97706; }
.status-out { background: #fef2f2; color: #dc2626; }

.images-box{
    border: 1px solid #eef2ff;
    background: #f9fafb;
    border-radius: 14px;
    padding: 14px 16px;
    grid-row: span 2;
}
.images-grid{
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 10px;
}
.images-grid img{
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background:#fff;
}

.desc-box{
    border: 1px solid #eef2ff;
    background: #f9fafb;
    border-radius: 14px;
    padding: 14px 16px;
    margin-top: 16px;
}
.desc-text{
    margin: 0;
    color:#374151;
    line-height: 1.5;
    font-weight: 500;
}

@media (max-width: 992px){
    .grid{ grid-template-columns: 1fr; }
    .images-box{ grid-row: auto; }
    .images-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
}
@media (max-width: 640px){
    .images-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
</style>

@php
    // Badge class mapping
    $statusClass = 'status-available';
    if (($item->status ?? '') === 'low') $statusClass = 'status-low';
    if (($item->status ?? '') === 'out') $statusClass = 'status-out';
@endphp

<div class="item-container">
    <a href="{{ route('therapist.items.index') }}" class="back-btn">
        <span style="font-size:16px;">←</span>
        <span>Back to Item List</span>
    </a>

    <div class="card-wrap">
        <h1 class="item-title">{{ $item->itemName }}</h1>
        <div class="item-sub">Item ID: {{ $item->itemID }}</div>

        <div class="grid">
            <div>
                <div class="info-box">
                    <div class="info-label">Category</div>
                    <div class="info-value">{{ $item->category }}</div>
                </div>

                <div class="info-box" style="margin-top:12px;">
                    <div class="info-label">Condition</div>
                    <div class="info-value">{{ $item->condition }}</div>
                </div>

                <div class="info-box" style="margin-top:12px;">
                    <div class="info-label">Stock Level</div>
                    <div class="info-value">{{ $item->stockLevel }}</div>
                </div>
            </div>

            <div>
                <div class="info-box">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                </div>

                <div class="info-box" style="margin-top:12px;">
                    <div class="info-label">Quantity</div>
                    <div class="info-value">{{ $item->quantity }}</div>
                </div>
            </div>

            <div class="images-box">
                <div class="info-label">Images</div>

                @if($item->images && $item->images->count())
                    <div class="images-grid">
                        @foreach($item->images as $img)
                            @php
                                // imagePath in DB examples:
                                // "items/foam-roller.jpg" OR "images/foam-roller.jpg" OR "foam-roller.jpg"
                                $path = ltrim($img->imagePath ?? '', '/');
                                $filename = basename($path);

                                // Try best order:
                                // 1) storage link: /storage/<path>
                                // 2) public/items/<filename>
                                // 3) public/images/<filename>
                                $candidates = [
                                    asset('storage/' . $path),
                                    asset('items/' . $filename),
                                    asset('images/' . $filename),
                                ];

                                $firstSrc = $candidates[0];
                                $fallback1 = $candidates[1];
                                $fallback2 = $candidates[2];
                            @endphp

                            <img
                                src="{{ $firstSrc }}"
                                alt="Item image"
                                onerror="if(this.dataset.fk1){this.src=this.dataset.fk1; this.dataset.fk1=''; return;} if(this.dataset.fk2){this.src=this.dataset.fk2; this.dataset.fk2=''; return;} this.style.display='none';"
                                data-fk1="{{ $fallback1 }}"
                                data-fk2="{{ $fallback2 }}"
                            >
                        @endforeach
                    </div>
                @else
                    <div style="color:#6b7280; margin-top:10px;">No image uploaded.</div>
                @endif
            </div>
        </div>

        <div class="desc-box">
            <div class="info-label">Description</div>
            <p class="desc-text">{{ $item->description }}</p>
        </div>
    </div>
</div>
@endsection