@extends('layouts.app')

@section('title', 'Inventory Dashboard')

@section('content')
{{-- 1. Bootstrap Assets (Required for Modals) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- 2. Your Custom CSS --}}
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

.alert-success { background: #d1fae5; color: #065f46; border-left-color: #10b981; }
.alert-error { background: #fee2e2; color: #991b1b; border-left-color: #ef4444; }
.no-data { text-align: center; padding: 50px 20px; color: #6b7280; font-style: italic; }
.no-data-icon { font-size: 34px; margin-bottom: 15px; color: #c7d2fe; }
.pagination-container { margin-top: 30px; display: flex; justify-content: center; }

/* ================= TRANSPARENT MODAL STYLES ================= */
.delete-modal .modal-dialog {
    max-width: 450px;
}

.delete-modal .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* ✅ Correct bootstrap backdrop target */
.modal-backdrop.show {
    opacity: 0.35 !important;
}

.modal-backdrop {
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}

.delete-modal .modal-header { border-bottom: none; padding: 0; display: none; }
.delete-modal .modal-body { padding: 40px 35px; text-align: center; }

.delete-icon-container {
    width: 80px;
    height: 80px;
    background: rgba(254, 226, 226, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    border: 2px solid rgba(220, 38, 38, 0.2);
}

.delete-icon { font-size: 32px; color: #dc2626; }

.modal-title {
    font-weight: 900;
    color: #111827;
    font-size: 22px;
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 15px;
    letter-spacing: 1px;
    word-spacing: 3px;
}

.modal-message {
    text-align: center;
    color: #4b5563;
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 25px;
    font-weight: 400;
    letter-spacing: 0.3px;
}

#itemNameToDelete { font-weight: 700; color: #111827; }

.confirmation-checkbox-container {
    background: rgba(249, 250, 251, 0.9);
    border-radius: 12px;
    border: 1px solid rgba(229, 231, 235, 0.6);
    padding: 18px 20px;
    margin-bottom: 30px;
    text-align: left;
}

.confirmation-checkbox {
    cursor: pointer;
    width: 18px;
    height: 18px;
    margin-right: 12px;
}

.confirmation-label {
    font-size: 14px;
    color: #4b5563;
    cursor: pointer;
    user-select: none;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.modal-footer-custom {
    display: flex;
    justify-content: center;
    gap: 15px;
    border-top: none;
    padding: 0;
}

.btn-cancel {
    border-radius: 10px;
    font-weight: 600;
    color: #374151;
    background-color: rgba(243, 244, 246, 0.95);
    border: 1px solid rgba(209, 213, 219, 0.8);
    padding: 12px 28px;
    font-size: 15px;
    transition: all 0.2s ease;
    min-width: 110px;
}

.btn-cancel:hover {
    background-color: rgba(229, 231, 235, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn-delete {
    border-radius: 10px;
    font-weight: 600;
    background-color: #dc2626;
    color: white;
    border: none;
    padding: 12px 28px;
    font-size: 15px;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    transition: all 0.2s ease;
    min-width: 110px;
}

.btn-delete:hover:not(:disabled) {
    background-color: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
}

.btn-delete:disabled {
    background-color: rgba(252, 165, 165, 0.8);
    color: rgba(255, 255, 255, 0.7);
    cursor: not-allowed;
    box-shadow: none;
}

@media (max-width: 768px) {
    .search-box { width: 100%; }
    .table-header { width: 100%; }
    .top-actions { justify-content: flex-start; }
}
</style>

<div class="inventory-container">
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

    {{-- ✅ ONE ADD BUTTON TOP RIGHT --}}
    <div class="top-actions">
        <a href="{{ route('admin.inventory.create') }}" class="add-btn">
            <i class="fas fa-plus-circle"></i> Add New Item
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-container">

        {{-- ✅ TITLE LEFT + SEARCH RIGHT (INSIDE CARD) --}}
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
                                        onclick="openDeleteModal('{{ $item->itemID }}', '{{ $item->itemName }}', '{{ route('admin.inventory.destroy', $item->itemID) }}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
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

{{-- DELETE CONFIRMATION MODAL --}}
<div class="modal fade delete-modal" id="deleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <div class="delete-icon-container">
                        <i class="fas fa-trash-alt delete-icon"></i>
                    </div>

                    <h3 class="modal-title">DELETE INVENTORY ITEM</h3>

                    <p class="modal-message">
                        Are you sure you want to delete '<span id="itemNameToDelete"></span>'?<br>
                        This action cannot be undone.
                    </p>

                    <div class="confirmation-checkbox-container">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input confirmation-checkbox" type="checkbox" id="confirmDeleteCheckbox">
                            <label class="form-check-label confirmation-label" for="confirmDeleteCheckbox">
                                I understand this action is permanent.
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-delete" id="deleteConfirmButton" disabled>Delete</button>
                    </div>
                </div>
            </form>
        </div>
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

    function openDeleteModal(itemId, itemName, deleteRoute) {
        document.getElementById('itemNameToDelete').textContent = itemName;
        document.getElementById('deleteForm').action = deleteRoute;

        document.getElementById('confirmDeleteCheckbox').checked = false;
        document.getElementById('deleteConfirmButton').disabled = true;

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
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

        const confirmCheckbox = document.getElementById('confirmDeleteCheckbox');
        const deleteButton = document.getElementById('deleteConfirmButton');

        if (confirmCheckbox && deleteButton) {
            confirmCheckbox.addEventListener('change', function() {
                deleteButton.disabled = !this.checked;
            });
        }

        const deleteModalElement = document.getElementById('deleteModal');
        if (deleteModalElement) {
            deleteModalElement.addEventListener('hidden.bs.modal', function() {
                if (confirmCheckbox) confirmCheckbox.checked = false;
                if (deleteButton) deleteButton.disabled = true;
                document.getElementById('deleteForm').action = '';
            });
        }

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => { this.style.transform = ''; }, 150);
            });
        });
    });
</script>
@endsection
