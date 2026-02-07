@extends('layouts.therapist')

@section('title', 'Usage History')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.history-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
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

/* ================= FILTER & ACTIONS ================= */
.header-actions {
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
}

/* Date Input */
.date-input {
    padding: 11px 18px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
    font-family: 'Inter', sans-serif;
    color: #374151;
    min-width: 160px;
}

.date-input:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
}

/* Search Button */
.btn-search {
    padding: 11px 24px;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(79, 70, 229, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(79, 70, 229, 0.35);
}

.btn-search:active {
    transform: translateY(0);
}

/* Add New Record Button */
.btn-add {
    padding: 11px 24px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
}

.btn-add:active {
    transform: translateY(0);
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
.history-table {
    width: 100%;
    border-collapse: collapse;
}

.history-table th {
    text-align: left;
    padding: 16px 14px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.history-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
}

.history-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.history-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* Center align specific columns */
.history-table th:first-child,
.history-table td:first-child {
    text-align: center;
    width: 80px;
}

.history-table th:nth-child(3),
.history-table td:nth-child(3) {
    width: 150px;
}

.history-table th:nth-child(4),
.history-table td:nth-child(4) {
    text-align: center;
    width: 150px;
}

.history-table th:last-child,
.history-table td:last-child {
    text-align: center;
    width: 120px;
}

/* ================= USAGE ID ================= */
.usage-id {
    font-weight: 600;
    color: #111827;
}

.usage-date {
    color: #6b7280;
}

/* ================= TOTAL ITEMS ================= */
.total-items {
    color: #374151;
    font-weight: 500;
}

/* ================= VIEW BUTTON ================= */
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
    .history-title {
        font-size: 22px;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .date-input,
    .btn-search,
    .btn-add {
        width: 100%;
        justify-content: center;
    }

    .history-table th,
    .history-table td {
        padding: 12px 10px;
        font-size: 13px;
    }
}
</style>

<div class="history-container">
    <!-- HEADER WITH TITLE AND ACTIONS -->
    <div class="history-header">
        <form method="GET" class="header-actions">
            <input type="date"
                name="date"
                class="date-input"
                value="{{ request('date') }}">
            <button class="btn-search">
                <i class="bi bi-search"></i> Search
            </button>
        </form>

    </div>

    <!-- TABLE CONTAINER -->
    <div class="table-container">
        <table class="history-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Usage ID</th>
                    <th>Date</th>
                    <th>Total Items</th>
                    <th>Action</th>
                </tr>
            </thead>
           <tbody>
                @if($records->count())
                    @foreach($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td class="usage-id">
                                UHG-{{ str_pad($record['usageID'], 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="usage-date">
                                {{ $record['usageDate'] }}
                            </td>

                            <td class="total-items">
                                {{ $record['totalItems'] }}
                            </td>

                            <td>
                                <a href="{{ route('therapist.view.history.details', $record['usageID']) }}"
                                class="btn-view">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="no-data">
                            <div class="no-data-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            No usage history found
                        </td>
                    </tr>
                @endif
            </tbody>

        </table>
    </div>
</div>

@endsection