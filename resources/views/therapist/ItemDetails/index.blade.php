@extends('layouts.therapist')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= CONTAINER ================= */
.inventory-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
}

/* ================= HEADER ================= */
.inventory-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.inventory-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

/* ================= SEARCH ================= */
.search-box {
    position: relative;
    min-width: 320px;
    width: 380px;
    max-width: 100%;
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
}

.search-input {
    width: 100%;
    padding: 11px 18px 11px 46px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
}

.search-input:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow:
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
}

.search-form {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

/* ================= TABLE CARD ================= */
.table-container {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

/* ================= TABLE ================= */
.inventory-table {
    width: 100%;
    border-collapse: collapse;
}

.inventory-table th {
    text-align: left;
    padding: 16px 14px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}

.inventory-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.inventory-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.inventory-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* ================= STATUS BADGES ================= */
.status-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
    text-transform: capitalize;
}

.status-available {
    background: #ecfdf5;
    color: #059669;
}

.status-low {
    background: #fffbeb;
    color: #d97706;
}

.status-out {
    background: #fef2f2;
    color: #dc2626;
}

/* fallback jika status lain */
.status-neutral {
    background: #f3f4f6;
    color: #374151;
}

/* ================= BUTTON ================= */
.select-btn {
    padding: 8px 22px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
    color: #fff;
}

.select-btn:active {
    transform: translateY(0);
}

/* ================= EMPTY STATE ================= */
.no-data {
    text-align: center;
    padding: 50px 20px;
    color: #6b7280;
    font-style: italic;
}

.no-data-icon {
    font-size: 34px;
    margin-bottom: 15px;
    color: #c7d2fe;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .inventory-title {
        font-size: 22px;
    }

    .search-box {
        width: 100%;
        min-width: 0;
    }

    .inventory-table th,
    .inventory-table td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .select-btn {
        padding: 6px 16px;
        font-size: 12px;
    }
}
</style>

<div class="inventory-container">

    <div class="inventory-header">
        <div class="header-left">
            <h1 class="inventory-title">Item Details</h1>
        </div>

        <div class="header-right">
            <form method="GET" action="{{ route('therapist.items.index') }}" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ $q ?? '' }}"
                        class="search-input"
                        placeholder="Search item name / category / ID"
                    >
                </div>

                <button class="select-btn" type="submit">Search</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="border-radius:12px;">{{ session('error') }}</div>
    @endif

    <div class="table-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th style="width:70px;">No.</th>
                    <th style="width:110px;">Item ID</th>
                    <th>Item Name</th>
                    <th style="width:180px;">Category</th>
                    <th style="width:110px;">Qty</th>
                    <th style="width:160px;">Stock Level</th>
                    <th style="width:140px;">Status</th>
                    <th style="width:140px; text-align:right;">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $index => $item)
                    @php
                        // status badge map (ikut data kau)
                        $s = strtolower(trim($item->status ?? ''));
                        $statusClass = 'status-neutral';

                        if (in_array($s, ['available'])) $statusClass = 'status-available';
                        elseif (in_array($s, ['low'])) $statusClass = 'status-low';
                        elseif (in_array($s, ['out', 'unavailable', 'not available'])) $statusClass = 'status-out';
                    @endphp

                    <tr>
                        <td>{{ $items->firstItem() + $index }}</td>
                        <td>{{ $item->itemID }}</td>
                        <td style="font-weight:600;">{{ $item->itemName }}</td>
                        <td style="text-transform: capitalize;">{{ $item->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-transform: capitalize;">{{ $item->stockLevel }}</td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('therapist.items.show', $item->itemID) }}" class="select-btn">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="no-data">
                            <i class="fas fa-box-open no-data-icon"></i>
                            <br>
                            No items found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 22px; display:flex; justify-content:center;">
        {{ $items->links() }}
    </div>

</div>
@endsection
