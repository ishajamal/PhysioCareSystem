@extends('layouts.therapist')

@section('title', 'Usage History')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(135deg, #f6f8ff 0%, #f0f4ff 100%);
    font-family: 'Inter', sans-serif;
    color: #1a1a1a;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ================= CONTAINER ================= */
.history-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
    min-height: 80vh;
}

/* ================= HEADER ================= */
.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.history-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

/* ================= FILTER & SEARCH ================= */
.filter-search {
    display: flex;
    gap: 10px;
    align-items: center;
}

.filter-box {
    position: relative;
    min-width: 200px;
}

.filter-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
    z-index: 1;
}

.date-input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
    font-family: 'Inter', sans-serif;
    color: #374151;
    height: 44px;
    box-sizing: border-box;
}

.date-input:focus {
    background: #ffffff;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
}

/* Search Button */
.search-btn {
    padding: 0 24px;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Inter', sans-serif;
    height: 44px;
    white-space: nowrap;
}

.search-btn:hover {
    background: #4338ca;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
}

.search-btn:active {
    transform: translateY(0);
}

/* ================= TABLE SECTION ================= */
.table-wrapper {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

/* Table Header */
.table-header {
    padding: 28px 30px;
    background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #eef2f7;
}

.table-header h2 {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.table-header h2 i {
    color: #4f46e5;
}

/* Table Styling */
.records-table {
    width: 100%;
    border-collapse: collapse;
}

.records-table thead {
    background: #f8fafc;
}

.records-table th {
    padding: 20px 25px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #eef2f7;
    white-space: nowrap;
}

.records-table th:first-child {
    padding-left: 30px;
}
.records-table th:nth-child(5),
.records-table td:nth-child(5) {
    width: 120px;
    min-width: 120px;
    text-align: center;
}

.records-table th:last-child {
    padding-right: 30px;
}

.records-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.records-table tbody tr:hover {
    background: #fafbff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.records-table td {
    padding: 22px 25px;
    font-size: 15px;
    color: #334155;
    vertical-align: middle;
}

.records-table td:first-child {
    padding-left: 30px;
    font-weight: 500;
    color: #64748b;
}

.records-table td:last-child {
    padding-right: 30px;
}

/* Table Cell Variations */
.record-id {
    font-weight: 700;
    color: #1a1a1a;
    font-size: 15px;
    display: inline-block;
    padding: 6px 15px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
    border-radius: 10px;
    border-left: 4px solid #4f46e5;
}

.record-date {
    font-weight: 500;
    color: #475569;
    font-size: 15px;
}

.record-date i {
    color: #94a3b8;
    margin-right: 8px;
    font-size: 14px;
}

.total-count {
    font-weight: 700;
    color: #2563eb;
    font-size: 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.total-count::before {
    content: '';
    width: 8px;
    height: 8px;
    background: #2563eb;
    border-radius: 50%;
}



/* ================= MODERN BUTTONS ================= */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    font-family: 'Segoe UI', sans-serif;
}

/* Cancel Button - Gray */
.btn-cancel {
    background-color: #f0f0f0;
    color: #333;
}

.btn-cancel:hover {
    background-color: #e0e0e0;
}

/* Submit Button - Green */
.btn-submit {
    background-color: #4caf50;
    color: white;
}

.btn-submit:hover {
    background-color: #43a047;
}

/* Add Item Button - Blue Gradient */
.btn-add {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-add:hover {
    background: linear-gradient(135deg, #1e40af, #1d4ed8);
}

/* Icon inside buttons */
.btn i {
    font-size: 18px;
}

/* ================= EMPTY STATE ================= */
.empty-state {
    padding: 80px 30px;
    text-align: center;
}

.empty-state .icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #94a3b8;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 600;
    color: #334155;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 15px;
    color: #64748b;
    margin: 0;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.5;
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.btn-edit, .btn-delete, .btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    flex-shrink: 0;
}

.btn-view {
    background-color: #dbeafe;
    color: #1e40af;
}

.btn-view:hover {
    background-color: #bfdbfe;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 64, 175, 0.2);
}

.btn-edit {
    background-color: #fef3c7;
    color: #b45309;
}

.btn-edit:hover {
    background-color: #fde68a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(180, 83, 9, 0.2);
}

.btn-delete {
    background-color: #fee2e2;
    color: #b91c1c;
}

.btn-delete:hover {
    background-color: #fca5a5;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(185, 28, 28, 0.2);
}
/* ================= FOOTER ================= */
.table-footer {
    padding: 20px 30px;
    background: #f8fafc;
    border-top: 1px solid #eef2f7;
    text-align: center;
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .history-container {
        padding: 20px 15px;
    }
    
    .history-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .history-title {
        font-size: 28px;
    }
    
    .filter-search {
        width: 100%;
    }
    
    .filter-box {
        flex: 1;
        min-width: unset;
    }
    
    .date-input {
        width: 100%;
    }
    
    .table-header {
        padding: 20px;
    }
    
    .records-table th,
    .records-table td {
        padding: 15px;
        font-size: 14px;
    }
    
    .records-table th:first-child,
    .records-table td:first-child {
        padding-left: 20px;
    }
    
    .records-table th:last-child,
    .records-table td:last-child {
        padding-right: 20px;
    }
    
    .record-id {
        padding: 4px 10px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .filter-search {
        flex-direction: column;
        gap: 10px;
    }
    
    .filter-box,
    .search-btn {
        width: 100%;
    }
    
    .records-table {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .records-table th,
    .records-table td {
        white-space: nowrap;
    }
    
    .table-footer {
        padding: 15px;
        font-size: 13px;
    }
}
</style>

<div class="history-container">
    <!-- HEADER -->
    <div class="history-header">
        <div class="header-left">
            <h1 class="history-title">Usage History</h1>
        </div>
        <div class="header-right">
            <form method="GET" class="filter-search">
                <div class="filter-box">
                    <i class="bi bi-calendar3 filter-icon"></i>
                    <input type="date"
                           name="date"
                           class="date-input"
                           value="{{ request('date') }}"
                           onchange="this.form.submit()">
                </div>
                <button type="submit" class="search-btn">
                    <i class="bi bi-search"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- TABLE SECTION -->
    <div class="table-wrapper">
        <!-- Table Header -->
        <div class="table-header">
            <h2><i class="bi bi-clock-history"></i> Recent Usage Records</h2>
        </div>

        <!-- Table Content -->
        <table class="records-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Usage ID</th>
                    <th>Date</th>
                    <th>Items Used</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($records->count())
                    @foreach($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="record-id">
                                    UHG-{{ str_pad($record['usageID'], 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="record-date">
                                <i class="bi bi-calendar"></i>
                                {{ $record['usageDate'] }}
                            </td>
                            <td>
                                <span class="total-count">
                                    {{ $record['totalItems'] }}
                                </span>
                            </td>
                            <td class="action-buttons">
                                <button type="button"
                                        class="btn-view"
                                        title="View Details"
                                        onclick="window.location='{{ route('therapist.view.history.details', $record['usageID']) }}'">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <button class="btn-delete" onclick="openModal('deleteModal{{ $record['usageID'] }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            <x-delete-modal
                                id="deleteModal{{ $record['usageID'] }}"
                                title="ARE YOU SURE YOU WANT TO DELETE THIS RECORD?"
                                message="This action cannot be undone."
                                route="{{ route('therapist.delete.usage', $record['usageID']) }}"
                                method="DELETE"
                            />

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <h3>No Records Found</h3>
                                <p>No usage history available for the selected date. Try a different date or check back later.</p>
                            </div>
                        </td>
                    </tr>
                @endif
                
            </tbody>
        </table>

        <!-- Table Footer -->
        @if($records->count())
            <div class="table-footer">
                Showing {{ $records->count() }} usage records
            </div>
        @endif
    </div>
</div>

<script>
// Add animation to table rows
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.records-table tbody tr');
    
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});

// Add auto-submit on date change
const dateInput = document.querySelector('.date-input');
if (dateInput) {
    dateInput.addEventListener('change', function() {
        if (this.value) {
            this.closest('form').submit();
        }
    });
}
</script>

@endsection