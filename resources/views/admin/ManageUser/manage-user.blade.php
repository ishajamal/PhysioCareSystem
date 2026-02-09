@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.main-content-users {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
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
    flex-wrap: wrap;
    gap: 20px;
}

.handle-users-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

/* ================= SEARCH CONTAINER ================= */
.search-container {
    display: flex;
    align-items: center;
}

.search-input-wrapper {
    position: relative;
    min-width: 300px;
}

.search-input-wrapper .fa-search {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
}

.search-input-wrapper .search-input {
    width: 100%;
    padding: 11px 18px 11px 46px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
}

.search-input-wrapper .search-input:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
}

/* ================= TABLE ================= */
.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th:nth-child(1),
.users-table td:nth-child(1) {
    width: 70px;
    min-width: 70px;
}

.users-table th:nth-child(2),
.users-table td:nth-child(2) {
    width: 180px;
    min-width: 180px;
}

.users-table th:nth-child(3),
.users-table td:nth-child(3) {
    width: 250px;
    min-width: 250px;
}

.users-table th:nth-child(4),
.users-table td:nth-child(4) {
    width: 100px;
    min-width: 100px;
}

.users-table th:nth-child(5),
.users-table td:nth-child(5) {
    width: 120px;
    min-width: 120px;
    text-align: center;
}

.users-table th {
    padding: 16px 10px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
    text-align: left;
}

.users-table td {
    padding: 16px 10px;
    font-size: 14px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.users-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.users-table tbody tr:hover {
    background: #eef2ff;
    transition: background 0.2s ease;
}

/* ================= ROLE BADGES ================= */
.role-badge {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
    text-align: center;
    min-width: 80px;
    box-sizing: border-box;
}

.role-admin {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.role-therapist {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}

/* ================= ACTION BUTTONS - SAME AS MAINTENANCE PAGE ================= */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.btn-edit, .btn-delete {
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

/* ================= PAGINATION ================= */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination .page-item {
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    border-radius: 8px;
    background: white;
    border: 1px solid #e5e7eb;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.pagination .page-link:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.pagination .active .page-link {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.pagination .disabled .page-link {
    background: #f9fafb;
    color: #9ca3af;
    cursor: not-allowed;
}

.pagination .page-link .fa-chevron-left,
.pagination .page-link .fa-chevron-right {
    font-size: 12px;
}

/* ================= EMPTY STATE ================= */
.no-results-row td {
    text-align: center;
    color: #6b7280;
    font-style: italic;
    padding: 40px !important;
    font-size: 16px;
}

/* ================= HIDDEN ROWS ================= */
.hidden-row {
    display: none;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .users-table th:nth-child(1),
    .users-table td:nth-child(1),
    .users-table th:nth-child(2),
    .users-table td:nth-child(2),
    .users-table th:nth-child(3),
    .users-table td:nth-child(3),
    .users-table th:nth-child(4),
    .users-table td:nth-child(4),
    .users-table th:nth-child(5),
    .users-table td:nth-child(5) {
        width: auto;
        min-width: auto;
    }
    
    .users-table {
        display: block;
        overflow-x: auto;
    }
}

@media (max-width: 768px) {
    .main-content-users {
        padding: 20px 15px;
    }

    .handle-users-title {
        font-size: 22px;
    }

    .table-title {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .search-container {
        width: 100%;
    }

    .search-input-wrapper {
        width: 100%;
        min-width: auto;
    }

    .table-container {
        padding: 15px;
    }
    
    .users-table th,
    .users-table td {
        padding: 12px 8px;
        font-size: 13px;
    }
    
    .btn-edit, .btn-delete {
        width: 34px;
        height: 34px;
        font-size: 15px;
    }
    
    .role-badge {
        font-size: 11px;
        padding: 5px 8px;
        min-width: 70px;
    }
}

@media (max-width: 480px) {
    .users-table {
        display: block;
        overflow-x: auto;
    }
    
    .action-buttons {
        gap: 6px;
    }
    
    .btn-edit, .btn-delete {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .role-badge {
        font-size: 10px;
        padding: 4px 6px;
        min-width: 65px;
    }
}
</style>

<div class="main-content-users">
    
    <div class="table-container">
        <div class="table-title">
            <span class="handle-users-title">Manage Users</span>
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" 
                           name="search" 
                           placeholder="Search ID, Name, or Email" 
                           class="search-input" 
                           value="{{ $search }}"
                           id="search-input">
                </div>
            </div>
        </div>
        
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="users-table-body">
                @forelse($users as $user)
                <tr class="user-row" data-search="{{ strtolower($user->userID . ' ' . $user->name . ' ' . $user->email . ' ' . $user->role) }}">
                    <td>{{ $user->userID }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.manage.user.edit', $user->userID) }}" class="btn-edit" title="Edit User">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <button class="btn-delete" onclick="openDeleteModal('deleteUser{{ $user->userID }}')" title="Delete User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <x-delete-modal
                    id="deleteUser{{ $user->userID }}"
                    title="DELETE USER"
                    message="Are you sure you want to delete user '{{ $user->name }}'? This action cannot be undone."
                    route="{{ route('admin.manage.user.delete', $user->userID) }}"
                    method="DELETE"
                />
                
                @empty
                <tr id="noResultsRow">
                    <td colspan="5">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($users->hasPages() && empty($search))
        <div class="pagination-container" id="pagination-container">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<script>
function openDeleteModal(modalId) {
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
        event.target.id && event.target.id.startsWith('deleteUser')) {
        event.target.classList.remove('show');
        event.target.classList.add('hidden');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const userRows = document.querySelectorAll(".user-row");
    const paginationContainer = document.getElementById("pagination-container");
    
    let noResultsRow = document.getElementById("noResultsRow");
    if (!noResultsRow && userRows.length > 0) {
        const tbody = document.getElementById("users-table-body");
        noResultsRow = document.createElement('tr');
        noResultsRow.id = 'noResultsRow';
        noResultsRow.innerHTML = '<td colspan="5" style="text-align: center">No users found</td>';
        noResultsRow.style.display = 'none';
        tbody.appendChild(noResultsRow);
    }

    function performSearch() {
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        if (paginationContainer) {
            paginationContainer.style.display = query ? 'none' : 'flex';
        }

        if (query === '') {
            userRows.forEach(row => {
                row.style.display = '';
            });
            if (noResultsRow) noResultsRow.style.display = 'none';
            return;
        }

        userRows.forEach(row => {
            const searchText = row.getAttribute('data-search').toLowerCase();
            const isMatch = searchText.includes(query);
            
            if (isMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResultsRow) {
            if (visibleCount === 0) {
                noResultsRow.style.display = 'table-row';
            } else {
                noResultsRow.style.display = 'none';
            }
        }
    }

    searchInput.addEventListener("input", performSearch);

    searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            performSearch();
        }
    });

    searchInput.addEventListener("search", function() {
        if (this.value === '') {
            performSearch();
        }
    });
});
</script>
@endsection