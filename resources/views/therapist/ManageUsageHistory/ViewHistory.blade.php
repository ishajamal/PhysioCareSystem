@extends('layouts.therapist')

@section('title', 'Usage Details')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.details-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
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

.header-left {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.details-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.details-subtitle {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

/* Back Button */
.btn-back {
    padding: 11px 24px;
    background: #6b7280;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(107, 114, 128, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(107, 114, 128, 0.35);
    background: #4b5563;
}

.btn-back:active {
    transform: translateY(0);
}

/* ================= INFO CARD ================= */
.info-card {
    background: white;
    border-radius: 18px;
    padding: 30px;
    margin-bottom: 25px;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    font-weight: 600;
}

.info-value {
    font-size: 16px;
    color: #111827;
    font-weight: 600;
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

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e5e7eb;
    flex-wrap: wrap;
    gap: 15px;
}

.table-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

/* Add Item Button */
.btn-add-item {
    padding: 9px 20px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-add-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
}

.btn-add-item:active {
    transform: translateY(0);
}

/* ================= TABLE ================= */
.details-table {
    width: 100%;
    border-collapse: collapse;
}

.details-table th {
    text-align: left;
    padding: 16px 14px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.details-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
}

.details-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.details-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* Center align specific columns */
.details-table th:first-child,
.details-table td:first-child {
    text-align: center;
    width: 80px;
}

.details-table th:last-child,
.details-table td:last-child {
    text-align: center;
    width: 150px;
}

.details-table th:nth-child(5),
.details-table td:nth-child(5) {
    text-align: center;
    width: 120px;
}

/* ================= PRODUCT INFO ================= */
.product-code {
    font-weight: 600;
    color: #111827;
}

.product-name {
    color: #6b7280;
}

.quantity-value {
    text-align: center;
    font-weight: 500;
    color: #111827;
}

/* ================= ACTION BUTTONS ================= */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

/* View Button */
.btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    background-color: #dbeafe;
    color: #1e40af;
    text-decoration: none;
}

.btn-view:hover {
    background-color: #bfdbfe;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 64, 175, 0.2);
}

/* Edit Button */
.btn-edit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    background-color: #fef3c7;
    color: #b45309;
    text-decoration: none;
}

.btn-edit:hover {
    background-color: #fde68a;
}

/* Delete Button */
.btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    background-color: #fee2e2;
    color: #b91c1c;
}

.btn-delete:hover {
    background-color: #fca5a5;
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
    .details-title {
        font-size: 24px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-add-item {
        width: 100%;
        justify-content: center;
    }

    .details-table th,
    .details-table td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .action-buttons {
        gap: 6px;
    }

    .btn-view,
    .btn-edit,
    .btn-delete {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
}
.modal-overlay {
    position: fixed;
    inset: 0; /* top:0 left:0 right:0 bottom:0 */
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.delete-modal {
    background: #f8eaea;
    width: 420px;
    max-width: 90%;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: pop .25s ease;
}

</style>

<div class="details-container">
    <!-- HEADER -->
    <div class="details-header">
        <div class="header-left">
            <h1 class="details-title">Usage Details</h1>
            <p class="details-subtitle">View detailed information about this usage record</p>
        </div>
        <a href="{{ route('therapist.usage.history') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to History
        </a>
    </div>

    <!-- INFO CARD -->
    <div class="info-card">
        <div class="info-grid">

            <div class="info-item">
                <div class="info-label">Usage ID</div>
                <div class="info-value">
                    UHG-{{ str_pad($usage->usageID, 3, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Date</div>
                <div class="info-value">
                    {{ $usage->usageDate->format('Y-m-d') }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Total Items</div>
                <div class="info-value">
                    {{ $totalItems }} Items
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Therapist</div>
                <div class="info-value">
                    {{ $usage->usedByUser->name }}
                </div>
            </div>

        </div>
    </div>


    <!-- ITEMS TABLE -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="bi bi-list-ul"></i> Items Used
            </div>
            <a href="#" class="btn-add-item">
                <i class="bi bi-plus-circle"></i> Add New Item
            </a>
        </div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity Used</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usage->itemUsages as $index => $itemUsage)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="product-code">
                            ITM-{{ str_pad($itemUsage->itemMaintenanceInfo->itemID, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="product-name">
                            {{ $itemUsage->itemMaintenanceInfo->itemName }}
                        </td>

                        <td>
                            {{ $itemUsage->itemMaintenanceInfo->category }}
                        </td>

                        <td class="quantity-value">
                            {{ $itemUsage->quantityUsed }}
                        </td>

                        <td>
                            <div class="action-buttons">

                                {{-- VIEW --}}
                                <a href="{{ route('therapist.view.history.item.details', [$usage->usageID, $itemUsage->itemMaintenanceInfo->itemID]) }}" class="btn-view" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('therapist.usage.edit', [$usage->usageID, $itemUsage->itemMaintenanceInfo->itemID]) }}" class="btn-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- DELETE --}}
                                <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $itemUsage->itemMaintenanceInfo->itemID }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>

                                

                            </div>
                            <!-- Delete modal component -->
                                <x-delete-modal
                                    id="deleteModal{{ $itemUsage->itemMaintenanceInfo->itemID }}"
                                    title="ARE YOU SURE YOU WANT TO DELETE THIS RECORD?"
                                    message="This action cannot be undone."
                                    route="{{ route('therapist.usage.delete', [$usage->usageID, $itemUsage->itemMaintenanceInfo->itemID]) }}"
                                    method="DELETE"
                                />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="no-data">
                                <div class="no-data-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                No items recorded for this usage.
                            </div>
                        </td>
                    </tr>
                    @endforelse

            </tbody>

        </table>
    </div>
</div>

@endsection