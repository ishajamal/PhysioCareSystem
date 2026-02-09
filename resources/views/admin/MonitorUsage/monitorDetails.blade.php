@extends('layouts.app')

@section('title', 'Usage Details')

@section('content')
{{-- Bootstrap Assets --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= CONTAINER ================= */
.details-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

/* ================= HEADER ================= */
.details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.details-title {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

/* ================= CARD STYLES ================= */
.detail-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
}

.card-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f3f4f6;
}

/* ================= INFO GRID ================= */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    padding: 15px;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.info-label {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

/* ================= TABLE STYLES ================= */
.items-table {
    width: 100%;
    border-collapse: collapse;
}

.items-table th {
    text-align: left;
    padding: 16px 14px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.items-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
}

.items-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.items-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* ================= BADGE STYLES ================= */
.status-badge {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
    text-transform: capitalize;
}

.badge-usage {
    background: #dbeafe;
    color: #0369a1;
}

.badge-equipment {
    background: #fecaca;
    color: #dc2626;
}

.badge-item {
    background: #ecfdf5;
    color: #059669;
}

/* ================= BUTTONS ================= */
.btn-back {
    padding: 11px 20px;
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-back:hover {
    background: #e5e7eb;
    border-color: #9ca3af;
    color: #111827;
}

.btn-export {
    padding: 11px 20px;
    background: #26599F;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(38, 89, 159, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-export:hover {
    background: #1a4070;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(38, 89, 159, 0.3);
}

/* ================= ALERTS ================= */
.alert-message {
    padding: 12px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { 
        opacity: 0; 
        transform: translateY(-10px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left-color: #10b981;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left-color: #ef4444;
}

/* ================= NO DATA ================= */
.no-data {
    text-align: center;
    padding: 50px 20px;
    color: #6b7280;
}

.no-data-icon {
    font-size: 48px;
    margin-bottom: 15px;
    color: #c7d2fe;
}

@media (max-width: 768px) {
    .details-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .items-table {
        font-size: 12px;
    }
    
    .items-table th,
    .items-table td {
        padding: 10px 8px;
    }
}
</style>

<div class="details-container">
    {{-- Success/Error Messages --}}
    @if(session('success'))
    <div class="alert-message alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-message alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- ✅ HEADER WITH BUTTONS --}}
    <div class="details-header">
        <h1 class="details-title">Usage Record Details</h1>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.usage.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <button class="btn-export" onclick="printDetails()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    {{-- ✅ USAGE RECORD INFO CARD --}}
    <div class="detail-card">
        <h2 class="card-title">Usage Record Information</h2>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Usage ID</div>
                <div class="info-value">#{{ $usageRecord->usageID }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Staff Name</div>
                <div class="info-value">{{ $usageRecord->usedByUser->name ?? 'Unknown' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Staff Role</div>
                <div class="info-value">{{ ucfirst($usageRecord->usedByUser->role ?? 'N/A') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Usage Date</div>
                <div class="info-value">{{ $usageRecord->usageDate->format('M d, Y') ?? 'N/A' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Total Items Used</div>
                <div class="info-value">
                    <span class="status-badge badge-usage">
                        {{ $itemUsages->count() }} {{ $itemUsages->count() === 1 ? 'Item' : 'Items' }}
                    </span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Total Quantity</div>
                <div class="info-value">{{ $itemUsages->sum('quantityUsed') }} units</div>
            </div>
        </div>
    </div>

    {{-- ✅ ITEMS USED TABLE --}}
    <div class="detail-card">
        <h2 class="card-title">Items Used in This Record</h2>

        @if($itemUsages->count() > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity Used</th>
                        <th>Unit</th>
                        <th>Stock Level</th>
                        <th>Condition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemUsages as $usage)
                        <tr>
                            <td>#{{ $usage->itemMaintenanceInfo->itemID ?? 'N/A' }}</td>
                            <td>
                                <strong>{{ $usage->itemMaintenanceInfo->itemName ?? 'Unknown Item' }}</strong>
                            </td>
                            <td>
                                <span class="status-badge badge-{{ strtolower($usage->itemMaintenanceInfo->category ?? 'item') }}">
                                    {{ ucfirst($usage->itemMaintenanceInfo->category ?? 'Item') }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge badge-usage">
                                    {{ $usage->quantityUsed }}
                                </span>
                            </td>
                            <td>{{ $usage->itemMaintenanceInfo->quantity ?? 'N/A' }}</td>
                            <td>
                                <strong>{{ $usage->itemMaintenanceInfo->stockLevel ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <span class="status-badge" style="background: #fef3c7; color: #d97706;">
                                    {{ ucfirst($usage->itemMaintenanceInfo->condition ?? 'Unknown') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <div class="no-data-icon">📦</div>
                <p>No items recorded in this usage record.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function printDetails() {
        window.print();
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-message');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    });

    @media print {
        .btn-back,
        .btn-export {
            display: none;
        }
    }
</script>

@endsection
