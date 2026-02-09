@extends('layouts.app')

@section('title', 'Monitor Usage')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= MAIN LAYOUT ================= */
.inventory-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
}

/* ================= HEADER & TOP ACTIONS ================= */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

/* ================= FILTER CARD ================= */
.filter-card {
    background: white;
    padding: 20px;
    border-radius: 20px; 
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
}

.filter-form-layout {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
}

.filter-input-wrapper { flex: 1; }
.filter-date-group { display: flex; gap: 10px; flex: 1.5; }

/* ROUNDER INPUTS (Pill Shape) */
.filter-input, .filter-select {
    width: 100%;
    height: 44px;
    padding: 0 20px; /* More padding for rounded corners */
    border: 1px solid #e5e7eb;
    border-radius: 30px; /* Rounder pill shape */
    font-size: 14px;
    color: #374151;
    outline: none;
    transition: all 0.2s;
    background-color: #f9fafb;
}

.filter-input:focus, .filter-select:focus {
    border-color: #26599F; /* Updated to Blue */
    background-color: white;
    box-shadow: 0 0 0 3px rgba(38, 89, 159, 0.1);
}

/* ================= TABLE CARD ================= */
.table-container {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.inventory-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.inventory-table th {
    background: #f9fafb;
    padding: 16px 24px;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e5e7eb;
}

.inventory-table td {
    padding: 16px 24px;
    font-size: 14px;
    color: #111827;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.inventory-table tbody tr:hover {
    background-color: #f9fafb;
    transition: background-color 0.2s ease;
}

/* ================= BUTTONS ================= */
.btn {
    height: 44px;
    padding: 0 25px;
    border-radius: 30px; /* Rounder pill shape */
    font-weight: 500;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none !important;
}

/* RESTORED BLUE COLOR (#26599F) */
.btn-primary, .refresh-btn { 
    background: #26599F; 
    color: white; 
    box-shadow: 0 2px 4px rgba(38, 89, 159, 0.2);
}

.btn-secondary { 
    background: #f3f4f6; 
    color: #4b5563; 
    border: 1px solid #e5e7eb !important;
}

.btn:hover { transform: translateY(-1px); }
.refresh-btn:hover, .btn-primary:hover { background: #1e4b8a; } /* Darker shade of blue on hover */

/* Empty State */
.no-data {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}
.no-data-icon { font-size: 40px; margin-bottom: 15px; display: block; opacity: 0.5; }

/* Summary Card Styles */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: white;
        padding: 20px 25px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .summary-card:hover {
        transform: translateY(-2px);
    }

    .summary-icon {
        width: 54px;
        height: 54px;
        background: #eff6ff;
        color: #26599F;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .summary-info h3 {
        margin: 0;
        font-size: 13px;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.05em;
    }

    .summary-info .value {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 4px 0;
    }

    .summary-info .sub-text {
        font-size: 13px;
        color: #059669;
        font-weight: 500;
    }
</style>

<div class="inventory-container">
    
    {{-- Header Section --}}
    <div class="header-section">
        <h1 class="page-title">Monitor Usage</h1>
        <button type="button" class="btn btn-primary" onclick="refreshMonitorData()">
            <i class="fas fa-sync-alt"></i> Refresh Data
        </button>
    </div>

    @if($mostUsedToday && $mostUsedToday->itemMaintenanceInfo)
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">
                <i class="fas fa-fire"></i>
            </div>
            <div class="summary-info">
                <h3>Most Used Item Today</h3>
                <div class="value">{{ $mostUsedToday->itemMaintenanceInfo->itemName }}</div>
                <div class="sub-text">
                    <i class="fas fa-arrow-up"></i> {{ $mostUsedToday->total_qty }} units used today
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Filter Card --}}
    <div class="filter-card">
        <form id="filterForm" method="GET" action="{{ route('admin.usage.dashboard') }}">
            <div class="filter-form-layout">
                
                <div class="filter-input-wrapper">
                    <input type="text" name="userName" value="{{ request('userName') }}" class="filter-input" placeholder="Search by staff name...">
                </div>

                <div class="filter-input-wrapper">
                    <select name="itemCategory" class="filter-select">
                        <option value="" disabled {{ request('itemCategory') ? '' : 'selected' }}>Select Category</option>
                        <option value="">All Categories</option>
                        <option value="equipment" {{ request('itemCategory') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="item" {{ request('itemCategory') == 'item' ? 'selected' : '' }}>Item</option>
                    </select>
                </div>

                <div class="filter-date-group">
                    <input type="date" name="dateStart" value="{{ request('dateStart') }}" class="filter-input" title="Start Date">
                    <input type="date" name="dateEnd" value="{{ request('dateEnd') }}" class="filter-input" title="End Date">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.usage.dashboard') }}" class="btn btn-secondary">Clear</a>
                </div>

            </div>
        </form>
    </div>
<!--  -->
    {{-- Table Card --}}
    <div class="table-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">NO</th>
                    <th>STAFF NAME</th>
                    <th>ITEM NAME</th>
                    <th>CATEGORY</th>
                    <th style="text-align: center;">QTY</th>
                    <th>DATE USED</th>                
                </tr>
            </thead>
            <tbody>
                @forelse($itemUsages as $itemUsage)
                <tr>
                    <td style="text-align: center; font-weight: 500; color: #6b7280;">
                        {{ ($itemUsages->currentPage() - 1) * $itemUsages->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <span style="font-weight: 500;">{{ $itemUsage->usageRecord->usedByUser->name ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $itemUsage->itemMaintenanceInfo->itemName ?? 'N/A' }}</td>
                    
                    {{-- Category displayed as text only --}}
                    <td style="color: #4b5563; font-weight: 500;">
                        {{ ucfirst($itemUsage->itemMaintenanceInfo->category ?? 'Item') }}
                    </td>

                    <td style="text-align: center; font-family: 'Courier New', monospace; font-weight: 600;">
                        {{ $itemUsage->quantityUsed ?? 0 }}
                    </td>
                    <td style="color: #6b7280;">
                        {{ $itemUsage->usageRecord && $itemUsage->usageRecord->usageDate 
                           ? $itemUsage->usageRecord->usageDate->format('d M, Y') 
                           : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data">
                        <span class="no-data-icon">📊</span>
                        <p>No usage records found matching your criteria.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="margin-top: 25px;">
            {{ $itemUsages->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
    function refreshMonitorData() {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
        btn.disabled = true;
        
        fetch('{{ route("admin.usage.refresh") }}')
            .then(() => location.reload())
            .catch(() => {
                alert('Refresh failed.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            });
    }
</script>
@endsection