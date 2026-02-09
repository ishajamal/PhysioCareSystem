@extends('layouts.app')

@section('title', 'Inventory Dashboard')

@section('content')
{{-- 1. Bootstrap Assets (NOT needed anymore for delete modal, but keep if you use elsewhere) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= CONTAINER ================= */
.inventory-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

/* ================= TOP BAR (NEW) ================= */
.top-actions {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 14px;
    gap: 10px;
    flex-wrap: wrap;
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

.header-left {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* ================= SEARCH ================= */
.search-box {
    position: relative;
    min-width: 260px;
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
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15), 0 8px 20px rgba(0, 0, 0, 0.05);
}

/* ================= TABLE CARD ================= */
.table-container {
    background: white;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

/* ================= TABLE HEADER INSIDE CARD (NEW) ================= */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.table-title {
    font-size: 28px;
    font-weight: 800;
    color: #111827;
    margin: 0;
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
}

.inventory-table td {
    padding: 16px 14px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
}

.inventory-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.inventory-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* ================= CATEGORY BADGES ================= */
.category-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
}

.category-item { background: #ecfdf5; color: #059669; }
.category-category { background: #e0f2fe; color: #0369a1; }
.category-date { background: #fef3c7; color: #d97706; }

/* ================= ACTION BUTTONS ================= */
.action-buttons {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
    border: none;
}

.action-btn:hover { transform: translateY(-2px); }

.view-btn { background: #e0f2fe; color: #0369a1; }
.view-btn:hover { background: #bae6fd; color: #075985; }

.edit-btn { background: #fef3c7; color: #d97706; }
.edit-btn:hover { background: #fde68a; color: #b45309; }

.delete-btn { background: #fee2e2; color: #dc2626; }
.delete-btn:hover { background: #fecaca; color: #b91c1c; }

/* ================= BUTTONS ================= */
.add-btn-container { display: flex; gap: 10px; }

.add-btn {
    padding: 10px 22px;
    background: #26599F;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(38, 89, 159, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.add-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(38, 89, 159, 0.35);
    background: #1a4070;
    color: white;
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
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-error { background: #fee2e2; color: #991b1b; border-left-color: #ef4444; }
.no-data { text-align: center; padding: 50px 20px; color: #6b7280; font-style: italic; }
.no-data-icon { font-size: 34px; margin-bottom: 15px; color: #c7d2fe; }
.pagination-container { margin-top: 30px; display: flex; justify-content: center; }

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .search-box { width: 100%; }
    .table-header { width: 100%; }
    .top-actions { justify-content: flex-start; }
}

/* =========================================================
   ✅ MAINTENANCE-STYLE DELETE MODAL
   ========================================================= */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}

.modal-overlay.hidden { display: none; }
.modal-overlay.show { display: flex; }

.modal-content {
    width: min(520px, 92vw);
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    position: relative;
    padding: 26px 28px;
}

.close-btn {
    position: absolute;
    right: 16px;
    top: 12px;
    border: none;
    background: transparent;
    font-size: 22px;
    color: #6b7280;
    cursor: pointer;
}

.icon-circle {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fee2e2;
    margin: 6px auto 14px;
}

.icon-circle i { color: #b91c1c; font-size: 22px; }

.modal-title {
    text-align: center;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.8px;
    margin: 0 0 10px;
    color: #111827;
    text-transform: uppercase;
}

.modal-message {
    text-align: center;
    color: #374151;
    margin: 0 0 14px;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    margin: 14px 0 18px;
    color: #374151;
}

.checkbox-container input { width: 16px; height: 16px; }

.button-container {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.cancel-btn {
    padding: 10px 22px;
    border-radius: 12px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color: #111827;
    font-weight: 700;
    cursor: pointer;
}

.delete-btn-modal {
    padding: 10px 22px;
    border-radius: 12px;
    background: #dc2626;
    border: none;
    color: white;
    font-weight: 700;
    cursor: pointer;
    opacity: 0.95;
}

.delete-btn-modal:disabled {
    background: #fca5a5;
    cursor: not-allowed;
}
</style>

<div class="inventory-container">
    {{-- ❌ SUCCESS REMOVED HERE (leave success popup to layouts.app only) --}}

    @if(session('error'))
        <div class="alert-message alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ✅ ONE ADD BUTTON TOP RIGHT --}}
    <div class="top-actions">
        <a href="{{ route('admin.inventory.create') }}" class="add-btn">
            <i class="fas fa-plus-circle"></i> Add New Item
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-container">
        {{-- TITLE LEFT + SEARCH RIGHT --}}
        <div class="table-header">
            <h1 class="table-title">Inventory Summary</h1>

            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input"
                       placeholder="Search"
                       onkeyup="searchItems()">
            </div>
        </div>

        <table class="inventory-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ITEM ID</th>
                    <th>NAME</th>
                    <th>CATEGORY</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration + (($items->currentPage() - 1) * $items->perPage()) }}</td>
                        <td>{{ $item->itemID }}</td>
                        <td>{{ $item->itemName }}</td>
                        <td>
                            @if(strtolower($item->category) == 'item')
                                <span class="category-badge category-item">Item</span>
                            @elseif(strtolower($item->category) == 'equipment')
                                <span class="category-badge category-category">Equipment</span>
                            @else
                                <span class="category-badge category-date">{{ $item->category }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.inventory.show', $item->itemID) }}" class="action-btn view-btn" title="View Item">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.inventory.edit', $item->itemID) }}" class="action-btn edit-btn" title="Edit Item">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                <button class="action-btn delete-btn"
                                        title="Delete Item"
                                        onclick="openModal('deleteModal{{ $item->itemID }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                            <x-delete-modal
                                id="deleteModal{{ $item->itemID }}"
                                title="ARE YOU SURE YOU WANT TO DELETE THIS RECORD?"
                                message="This action cannot be undone."
                                route="{{ route('admin.inventory.destroy', $item->itemID) }}"
                                method="DELETE"
                            />
                        </td>
                    </tr>
                @empty
                    <tr class="no-data-row">
                        <td colspan="5" class="no-data">
                            <div class="no-data-icon">📦</div>
                            No inventory items found.
                            <a href="{{ route('admin.inventory.create') }}" style="color: #26599F; text-decoration: none; font-weight: 600; margin-left: 5px;">
                                Add your first item
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($items->hasPages())
            <div class="pagination-container">
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

<script>
    function searchItems() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.inventory-table tbody tr');

        rows.forEach(row => {
            if (row.classList.contains('no-data-row')) return;
            const code = row.cells[1].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const category = row.cells[3].textContent.toLowerCase();

            row.style.display = (code.includes(searchTerm) || name.includes(searchTerm) || category.includes(searchTerm))
                ? ''
                : 'none';
        });
    }

    // ✅ same functions as Maintenance
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

    // auto-hide ONLY local alerts (error). success is handled by layouts.app now.
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
</script>
@endsection

