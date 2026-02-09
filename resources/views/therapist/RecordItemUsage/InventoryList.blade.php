@extends('layouts.therapist')

@section('title', 'Inventory List')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.inventory-container {
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
    box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.05);
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

/* ================= STATUS BADGES ================= */
.status-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: inline-block;
}

.status-available {
    background: #ecfdf5;
    color: #059669;
}

.status-low {
    background: #fffbeb;
    color: #d97706;
}

.status-out {
    background: #fef2f2;
    color: #dc2626;
}

/* ================= BUTTON ================= */
.select-btn {
    padding: 8px 22px;
     background: #2563eb;
    color: white;
    border: none;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
}

.select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
}

.select-btn:active {
    transform: translateY(0);
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
    .inventory-title {
        font-size: 22px;
    }

    .search-box {
        width: 100%;
    }

    .inventory-table th,
    .inventory-table td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .select-btn {
        padding: 6px 16px;
        font-size: 12px;
    }
}
</style>


<div class="inventory-container">
    <!-- HEADER DENGAN TITLE DAN SEARCH -->
    <div class="inventory-header">
        <div class="header-left">
            <h1 class="inventory-title">Inventory List</h1>
        </div>
        <div class="header-right">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" 
                       class="search-input" 
                       placeholder="Search items..."
                       id="searchInput"
                       onkeyup="searchItems()">
            </div>
        </div>
    </div>

    <!-- TABLE CONTAINER -->
    <div >
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Stock Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="inventoryTableBody">
                @if($items->count() > 0)
                    @foreach($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->itemID }}</td>
                        <td>{{ $item->itemName }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            @php
                                $stockClass = '';
                                $stockLevel = 10; // Example threshold, adjust as needed
                                if($item->quantity > $stockLevel) {
                                    $stockClass = 'status-available'; // High stock
                                    $stockText = 'High';
                                } else {
                                    $stockClass = 'status-low'; // Low stock
                                    $stockText = 'Low';
                                }
                            @endphp
                            <span class="status-badge {{ $stockClass }}">
                                {{ $stockText }}
                            </span>
                        </td>

                        <td>
                            <button class="select-btn" onclick="window.location.href='{{ route('therapist.add.usage.record', ['itemID' => $item->itemID]) }}'">
                                Select
                            </button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-box-open no-data-icon"></i>
                            <br>
                            No inventory items found
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    // Function untuk live search
    function searchItems() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#inventoryTableBody tr');
        
        rows.forEach(row => {
            // Skip the "no data" row
            if (row.querySelector('.no-data')) return;
            
            const code = row.cells[1].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const category = row.cells[3].textContent.toLowerCase();
            
            if (code.includes(searchTerm) || name.includes(searchTerm) || category.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    
</script>
@endsection