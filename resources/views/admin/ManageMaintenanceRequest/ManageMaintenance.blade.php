@extends('layouts.app')

@section('title', 'Manage Maintenance Request')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.main-content-maintenance {
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

/* ================= TABLE CONTAINER ================= */
.table-container {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.08),
        0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

/* ================= TABLE TITLE BAR ================= */
.table-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.handle-maintenance-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.search-container {
    position: relative;
    min-width: 260px;
}

.search-container .fa-search {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
}

.search-container .search-input {
    width: 100%;
    padding: 11px 18px 11px 46px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
}

.search-container .search-input:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
}

.inventory-table {
    width: 100%;
    border-collapse: collapse;
}

.inventory-table th:nth-child(1),
.inventory-table td:nth-child(1) {
    width: 60px;
    min-width: 60px;
}

.inventory-table th:nth-child(2),
.inventory-table td:nth-child(2) {
    width: 100px;
    min-width: 100px;
}

.inventory-table th:nth-child(3),
.inventory-table td:nth-child(3) {
    width: 80px; 
    min-width: 80px;
}

.inventory-table th:nth-child(4),
.inventory-table td:nth-child(4) {
    width: 150px; /* User Name */
    min-width: 150px;
}

.inventory-table th:nth-child(5),
.inventory-table td:nth-child(5) {
    width: 120px; 
    min-width: 120px;
}

.inventory-table th:nth-child(6),
.inventory-table td:nth-child(6) {
    width: 150px;
    min-width: 150px;
}

.inventory-table th:nth-child(7),
.inventory-table td:nth-child(7) {
    width: 120px;
    min-width: 120px;
    text-align: center;
}

.inventory-table th {
    padding: 16px 10px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
    text-align: left;
}

.inventory-table td {
    padding: 16px 10px;
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

/* ================= STATUS STYLES ================= */
.status-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
    vertical-align: middle;
}

.status-pending {
    background: #f59e0b; 
}

.status-in-progress {
    background: #3b82f6; 
}

.status-approved {
    background: #10b981; 
}

.status-rejected {
    background: #ef4444; 
}

.status-completed {
    background: #10b981; 
}

.status-cancelled {
    background: #6b7280; 
}

/* ================= STATUS BADGES ================= */
.status-badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    min-width: 90px;
    box-sizing: border-box;
}

.status-pending-badge {
    background: #fffbeb;
    color: #d97706;
}

.status-in-progress-badge {
    background: #eff6ff;
    color: #2563eb;
}

.status-approved-badge {
    background: #ecfdf5;
    color: #059669;
}

.status-rejected-badge {
    background: #fef2f2;
    color: #dc2626;
}

.status-completed-badge {
    background: #ecfdf5;
    color: #059669;
}

.status-cancelled-badge {
    background: #f3f4f6;
    color: #6b7280;
}

/* ================= ACTION BUTTONS ================= */
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

.delete-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background-color: #fee2e2;
    color: #b91c1c;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    font-size: 16px;
}

.delete-btn:hover {
    background-color: #fca5a5;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(185, 28, 28, 0.2);
}

/* ================= EMPTY STATE ================= */
#noResultsRow td {
    text-align: center;
    color: #6b7280;
    font-style: italic;
    padding: 40px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .inventory-table th:nth-child(1),
    .inventory-table td:nth-child(1),
    .inventory-table th:nth-child(2),
    .inventory-table td:nth-child(2),
    .inventory-table th:nth-child(3),
    .inventory-table td:nth-child(3),
    .inventory-table th:nth-child(4),
    .inventory-table td:nth-child(4),
    .inventory-table th:nth-child(5),
    .inventory-table td:nth-child(5),
    .inventory-table th:nth-child(6),
    .inventory-table td:nth-child(6),
    .inventory-table th:nth-child(7),
    .inventory-table td:nth-child(7) {
        width: auto;
        min-width: auto;
    }
    
    .inventory-table {
        display: block;
        overflow-x: auto;
    }
}

@media (max-width: 768px) {
    .main-content-maintenance {
        padding: 20px 15px;
    }

    .handle-maintenance-title {
        font-size: 22px;
    }

    .table-title {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .search-container {
        width: 100%;
        min-width: auto;
    }

    .table-container {
        padding: 15px;
    }

    .inventory-table th,
    .inventory-table td {
        padding: 12px 8px;
        font-size: 13px;
    }
    
    .action-buttons {
        gap: 8px;
    }
    
    .btn-view, .btn-edit, .btn-delete, .delete-btn {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .status-badge {
        font-size: 11px;
        padding: 5px 8px;
        min-width: 80px;
    }
}

@media (max-width: 480px) {
    .inventory-table {
        display: block;
        overflow-x: auto;
    }
    
    .action-buttons {
        gap: 6px;
    }
    
    .btn-view, .btn-edit, .btn-delete, .delete-btn {
        width: 30px;
        height: 30px;
        font-size: 13px;
    }
    
    .status-badge {
        font-size: 10px;
        padding: 4px 6px;
        min-width: 70px;
    }
}
</style>

<div class="main-content-maintenance">
    <div class="table-container">
        <div class="table-title">
            <span class="handle-maintenance-title">Maintenance Request</span>
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search" class="search-input" id="search-input" />
            </div>
        </div>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Request ID</th>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Status</th>
                    <th>Equipment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="maintenance-table-body">
                @forelse($requests as $index => $row)
                @php
                    $statusClass = strtolower(str_replace(' ', '-', $row->maintenanceRequest->status));
                @endphp
                <tr data-row-id="{{ $row->requestID }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->requestID }}</td>
                    <td>{{ $row->maintenanceRequest->userID }}</td>
                    <td>{{ $row->maintenanceRequest->user->name ?? 'Unknown' }}</td>
                    <td>
                        <span class="status-indicator status-{{ $statusClass }}"></span>
                        <span class="status-badge status-{{ $statusClass }}-badge">
                            {{ $row->maintenanceRequest->status }}
                        </span>
                    </td>
                    <td>{{ $row->itemInfo->itemName ?? 'N/A' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.maintenance.view', $row->requestID) }}" class="btn-view" title="View Details">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.maintenance.edit', $row->requestID) }}" class="btn-edit" title="Edit Request">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <button class="delete-btn" onclick="openModal('deleteModal{{ $row->requestID }}')" title="Delete Request">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <x-delete-modal
                        id="deleteModal{{ $row->requestID }}"
                        title="ARE YOU SURE YOU WANT TO DELETE THIS RECORD?"
                        message="This action cannot be undone."
                        route="{{ route('admin.maintenance.destroy', $row->requestID) }}"
                        method="DELETE"
                    />
                
                @empty
                <tr id="noResultsRow">
                    <td colspan="7" style="text-align: center">No record found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        
        if (modal) {
            modal.classList.remove('hidden'); 
            modal.classList.add('show');
            
            var checkbox = document.getElementById('confirmCheck' + modalId);
            var deleteBtn = document.getElementById('deleteBtn' + modalId);

            if (checkbox && deleteBtn) {
                checkbox.checked = false;
                deleteBtn.disabled = true;

                checkbox.onchange = function() {
                    deleteBtn.disabled = !this.checked;
                };
            }
        } else {
            console.error('Modal not found: ' + modalId);
        }
    }

    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.classList.add('hidden'); 
        }
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay') && 
            event.target.id && event.target.id.startsWith('deleteModal')) {
            event.target.classList.remove('show');
            event.target.classList.add('hidden');
        }
    }

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");

    searchInput.addEventListener("input", function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll("#maintenance-table-body tr:not(#noResultsRow)");
        let visibleCount = 0;

        rows.forEach(row => {
            const match = row.innerText.toLowerCase().includes(query);
            row.style.display = match ? "" : "none";
            if(match) visibleCount++;
        });

        const noRes = document.getElementById("noResultsRow");
        if (visibleCount === 0) {
            if (!noRes) {
                const newRow = document.createElement('tr');
                newRow.id = 'noResultsRow';
                newRow.innerHTML = `<td colspan="7" style="text-align: center">No record found</td>`;
                document.getElementById("maintenance-table-body").appendChild(newRow);
            } else {
                noRes.style.display = "table-row";
            }
        } else if (noRes) {
            noRes.style.display = "none";
        }
    });
});
</script>
@endsection