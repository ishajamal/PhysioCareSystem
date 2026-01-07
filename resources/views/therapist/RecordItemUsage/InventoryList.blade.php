@extends('layouts.therapist')

@section('title', 'Inventory List')

@section('content')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap");
    .inventory-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
        min-height: 80vh;
    }

    /* HEADER STYLE */
    .inventory-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-left {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .inventory-title {
        font-size: 36px;
        font-weight: 600;
        color: #333;
        margin: 0;
        font-family: 'Cardo';
        letter-spacing: 1px;
    }

    .header-right {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-box {
        position: relative;
        min-width: 250px;
    }

    /* ROUNDED-PILL SEARCH INPUT */
    .search-input {
        width: 100%;
        padding: 10px 20px 10px 45px;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 14px;
        background: white;
        transition: all 0.3s ease;
        outline: none;
    }

    .search-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 14px;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        width: 100%;
    }

    .inventory-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 20px;
        font-family: 'Segoe UI', sans-serif;
    }

    .inventory-table th {
        text-align: left;
        padding: 15px;
        font-weight: 600;
        color: #333;
        font-size: 15px;
        border-bottom: 2px solid #e0e0e0;
        background: #f8f9fa;
    }

    .inventory-table td {
        padding: 15px;
        color: #444;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    .inventory-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .inventory-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .inventory-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BUTTON BIRU PEKAT */
    .select-btn {
        padding: 8px 20px;
        background: #1e40af;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 100px;
        box-shadow: 0 2px 4px rgba(30, 64, 175, 0.2);
    }

    .select-btn:hover {
        background: #1e3a8a;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(30, 64, 175, 0.3);
    }

    .select-btn:active {
        background: #1e3a8a;
        transform: translateY(0);
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.2);
    }

    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        font-style: italic;
        font-size: 14px;
    }

    .no-data-icon {
        font-size: 30px;
        margin-bottom: 15px;
        color: #ccc;
        opacity: 0.5;
    }

    /* Status badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .status-available {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .status-low {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .status-out {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .inventory-container {
            padding: 20px 10px;
        }
        
        .inventory-header {
            flex-direction: column;
            align-items: stretch;
            margin-bottom: 20px;
        }
        
        .inventory-title {
            font-size: 20px;
        }
        
        .header-right {
            width: 100%;
        }
        
        .search-box {
            min-width: 100%;
        }
        
        .search-input {
            font-size: 13px;
            padding: 8px 15px 8px 40px;
        }
        
        .table-container {
            padding: 15px;
        }
        
        .inventory-table {
            font-size: 13px;
        }
        
        .inventory-table th,
        .inventory-table td {
            padding: 12px 10px;
            font-size: 13px;
        }
        
        .select-btn {
            padding: 6px 15px;
            font-size: 13px;
            min-width: 80px;
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
    <div class="table-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Status</th>
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
                                $statusClass = '';
                                if($item->status == 'available') {
                                    $statusClass = 'status-available';
                                } elseif($item->status == 'low') {
                                    $statusClass = 'status-low';
                                } elseif($item->status == 'out') {
                                    $statusClass = 'status-out';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($item->status) }}
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