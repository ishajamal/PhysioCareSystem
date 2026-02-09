@extends('layouts.therapist')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.mr-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

/* Header */
.mr-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 18px;
}

.mr-title {
    font-size: 34px;
    font-weight: 800;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.6px;
}

/* Search pill */
.search-box {
    position: relative;
    min-width: 320px;
    flex: 1;
    max-width: 520px;
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
    transition: all 0.25s ease;
    outline: none;
}

.search-input:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow:
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
}

/* Search button */
.search-btn {
    padding: 9px 18px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.search-btn:hover {
    border-color: #2563eb;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.15);
    transform: translateY(-1px);
}

/* Table card */
.table-container {
    background: white;
    border-radius: 18px;
    padding: 18px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

/* Table */
.mr-table {
    width: 100%;
    border-collapse: collapse;
}

.mr-table th {
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

.mr-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.mr-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.mr-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

.truncate {
    max-width: 520px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Pagination center */
.pagination-wrap {
    margin-top: 18px;
    display: flex;
    justify-content: center;
}

/* ============ STATUS (KEKAL STYLE KAU) ============ */
.status-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
    vertical-align: middle;
}

.status-pending { background: #f59e0b; }
.status-in-progress { background: #3b82f6; }
.status-approved { background: #10b981; }
.status-rejected { background: #ef4444; }
.status-completed { background: #10b981; }
.status-cancelled { background: #6b7280; }

.status-badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    min-width: 90px;
    box-sizing: border-box;
    text-transform: lowercase;
}

.status-pending-badge { background: #fffbeb; color: #d97706; }
.status-in-progress-badge { background: #eff6ff; color: #2563eb; }
.status-approved-badge { background: #ecfdf5; color: #059669; }
.status-rejected-badge { background: #fef2f2; color: #dc2626; }
.status-completed-badge { background: #ecfdf5; color: #059669; }
.status-cancelled-badge { background: #f3f4f6; color: #6b7280; }

/* ✅ FIX ALIGN DOT + BADGE */
.status-wrap{
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.status-wrap .status-indicator{
    margin-right: 0; /* sebab gap dah handle spacing */
}

/* ============ ACTION BUTTONS (FARISHA STYLE) ============ */
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

/* Responsive */
@media (max-width: 768px) {
    .mr-title { font-size: 22px; }
    .search-box { min-width: 100%; max-width: 100%; }
    .mr-table th, .mr-table td { padding: 12px 10px; font-size: 13px; }
}
</style>

<div class="mr-container">

    <div class="mr-header">
        <h1 class="mr-title">Maintenance Request</h1>

        <a href="{{ route('therapist.maintenance.create') }}" class="blue-button">
            + Add New Maintenance Request
        </a>
    </div>

    <form method="GET" action="{{ route('therapist.maintenance.index') }}" class="d-flex gap-2 align-items-center mb-3" style="flex-wrap:wrap;">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                name="q"
                value="{{ $q ?? '' }}"
                class="search-input"
                placeholder="Search by Request ID / Status / Issue / Equipment"
            >
        </div>
        <button class="search-btn" type="submit">Search</button>
    </form>

    <div class="table-container">
        <div class="table-responsive">
            <table class="mr-table">
                <thead>
                    <tr>
                        <th style="width:70px;">No.</th>
                        <th style="width:120px;">Request ID</th>
                        <th style="min-width:220px;">Equipment Name</th>
                        <th style="min-width:280px;">Issue</th>
                        <th style="width:170px;">Date</th>
                        <th style="width:180px;">Status</th>
                        <th style="width:140px; text-align:center;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rows as $i => $r)
                        @php
                            $equipmentName = $r->equipmentName ?? '-';
                            $issueText = $r->itemIssue ?? '-';

                            $statusRaw = trim($r->status ?? 'pending');
                            $status = strtolower($statusRaw);

                            $dotClass = 'status-pending';
                            $badgeClass = 'status-badge status-pending-badge';
                            $label = 'pending';

                            if (in_array($status, ['pending'])) {
                                $dotClass = 'status-pending';
                                $badgeClass = 'status-badge status-pending-badge';
                                $label = 'pending';
                            } elseif (in_array($status, ['in progress','in-progress','in_progress','processing'])) {
                                $dotClass = 'status-in-progress';
                                $badgeClass = 'status-badge status-in-progress-badge';
                                $label = 'in progress';
                            } elseif (in_array($status, ['approved','accept','accepted'])) {
                                $dotClass = 'status-approved';
                                $badgeClass = 'status-badge status-approved-badge';
                                $label = 'approved';
                            } elseif (in_array($status, ['rejected','reject','declined'])) {
                                $dotClass = 'status-rejected';
                                $badgeClass = 'status-badge status-rejected-badge';
                                $label = 'rejected';
                            } elseif (in_array($status, ['completed','done'])) {
                                $dotClass = 'status-completed';
                                $badgeClass = 'status-badge status-completed-badge';
                                $label = 'completed';
                            } elseif (in_array($status, ['cancelled','canceled'])) {
                                $dotClass = 'status-cancelled';
                                $badgeClass = 'status-badge status-cancelled-badge';
                                $label = 'cancelled';
                            }

                            $dateText = '-';
                            if (!empty($r->dateSubmitted)) {
                                try {
                                    $dateText = \Carbon\Carbon::parse($r->dateSubmitted)->format('d M Y');
                                } catch (\Throwable $e) {
                                    $dateText = $r->dateSubmitted;
                                }
                            }
                        @endphp

                        <tr>
                            <td>{{ $rows->firstItem() + $i }}</td>
                            <td>#{{ $r->requestID }}</td>

                            <td>
                                <div class="fw-semibold truncate" style="max-width: 260px;">
                                    {{ $equipmentName }}
                                </div>
                            </td>

                            <td>
                                <div class="truncate" style="max-width: 520px;">
                                    {{ $issueText }}
                                </div>
                            </td>

                            <td>{{ $dateText }}</td>

                            <td>
                                <div class="status-wrap">
                                    <span class="status-indicator {{ $dotClass }}"></span>
                                    <span class="{{ $badgeClass }}">{{ $label }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('therapist.maintenance.show', $r->requestID) }}" class="btn-view" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No maintenance request history yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrap">
        {{ $rows->links() }}
    </div>
</div>
@endsection
