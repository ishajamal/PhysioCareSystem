@extends('layouts.app')

@section('title', 'View Inventory Item')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= CONTAINER ================= */
.view-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

/* ================= HEADER ================= */
.view-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 12px;
}

.view-title {
    font-size: 28px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 10px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color: #111827;
    font-weight: 700;
    text-decoration: none;
    transition: .2s ease;
}

.back-btn:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

/* ================= GRID ================= */
.details-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr;
    gap: 18px;
}

@media (max-width: 992px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
}

/* ================= CARDS ================= */
.cardx {
    background: #fff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.section-title {
    font-size: 14px;
    font-weight: 900;
    color: #111827;
    margin: 0 0 14px 0;
}

/* ================= TABLE ================= */
.details-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.details-table th {
    width: 35%;
    text-align: left;
    padding: 12px 10px;
    color: #6b7280;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .6px;
    border-bottom: 1px solid #eef2f7;
}

.details-table td {
    padding: 12px 10px;
    color: #111827;
    border-bottom: 1px solid #eef2f7;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
}

.badge-item { background: #ecfdf5; color: #059669; }
.badge-equipment { background: #e0f2fe; color: #0369a1; }
.badge-available { background: #ecfdf5; color: #059669; }
.badge-maintenance { background: #fef3c7; color: #d97706; }
.badge-inuse { background: #e0e7ff; color: #3730a3; }
.badge-out { background: #fee2e2; color: #b91c1c; }

/* ================= IMAGE ================= */
.img-box {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px;
    background: #fff;
}

.img-preview {
    width: 100%;
    height: 240px;
    border-radius: 12px;
    border: 1px solid #eef2f7;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.img-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.small-note {
    font-size: 12px;
    color: #6b7280;
    text-align: center;
}
</style>

<div class="view-container">
    <!-- HEADER -->
    <div class="view-header">
        <h1 class="view-title">Inventory Item Details</h1>
        <a href="{{ route('admin.inventory.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="details-grid">
        <!-- LEFT: DETAILS -->
        <div class="cardx">
            <h2 class="section-title">Item / Equipment Information</h2>

            <table class="details-table">
                <tr>
                    <th>ID</th>
                    <td>{{ $item->id }}</td>
                </tr>
                <tr>
                    <th>Product Code</th>
                    <td>{{ $item->product_code }}</td>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <td>{{ $item->product_name }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>
                        @if(strtolower($item->category) == 'equipment')
                            <span class="status-badge badge-equipment">Equipment</span>
                        @else
                            <span class="status-badge badge-item">Item</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @php $st = strtolower($item->status ?? ''); @endphp
                        @if($st === 'available')
                            <span class="status-badge badge-available">Available</span>
                        @elseif($st === 'maintenance')
                            <span class="status-badge badge-maintenance">Maintenance</span>
                        @elseif($st === 'in-use' || $st === 'in use')
                            <span class="status-badge badge-inuse">In Use</span>
                        @elseif($st === 'out-of-stock' || $st === 'out of stock')
                            <span class="status-badge badge-out">Out of Stock</span>
                        @else
                            <span class="status-badge badge-maintenance">{{ $item->status }}</span>
                        @endif
                    </td>
                </tr>

                <tr><th>Quantity</th><td>{{ $item->quantity ?? '-' }}</td></tr>
                <tr><th>Unit</th><td>{{ $item->unit ?? '-' }}</td></tr>
                <tr><th>Brand</th><td>{{ $item->brand ?? '-' }}</td></tr>
                <tr><th>Model</th><td>{{ $item->model ?? '-' }}</td></tr>
                <tr><th>Serial Number</th><td>{{ $item->serial_number ?? '-' }}</td></tr>
                <tr><th>Location</th><td>{{ $item->location ?? '-' }}</td></tr>
                <tr><th>Description</th><td>{{ $item->description ?? '-' }}</td></tr>
                <tr><th>Notes</th><td>{{ $item->notes ?? '-' }}</td></tr>
            </table>
        </div>

        <!-- RIGHT: IMAGE -->
        <div class="cardx">
            <h2 class="section-title">Item / Equipment Image</h2>

            <div class="img-box">
                <div class="img-preview">
                    @if(!empty($item->image_path))
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="Item Image">
                    @else
                        <div class="small-note">No image uploaded</div>
                    @endif
                </div>

                <div class="small-note" style="margin-top:10px;">
                    Uploaded images are stored in <b>storage/app/public</b>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
