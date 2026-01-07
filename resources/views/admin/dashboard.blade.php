@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Report & Analytics')

@section('content')
<style>
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 30px 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .stat-icon.blue {
        background: #e3f2fd;
        color: #2196f3;
    }

    .stat-icon.orange {
        background: #fff3e0;
        color: #ff9800;
    }

    .stat-icon.green {
        background: #e8f5e9;
        color: #4caf50;
    }

    .stat-content h3 {
        font-size: 2rem;
        color: var(--dark);
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-content p {
        color: var(--gray);
        font-size: 0.9rem;
        line-height: 1.3;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h2 {
        color: var(--dark);
        font-size: 1.3rem;
    }

    .card-header .filter {
        padding: 8px 15px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--gray);
        background: white;
        cursor: pointer;
    }

    /* Inventory Section */
    .inventory-status {
        background: #fff8f0;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid var(--secondary);
    }

    .inventory-status .status-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .inventory-status .status-header span:first-child {
        color: var(--gray);
        font-style: italic;
    }

    .inventory-status .status-header span:last-child {
        color: var(--gray);
        font-style: italic;
    }

    .inventory-status .warning {
        color: var(--secondary);
        font-size: 0.85rem;
        font-style: italic;
        margin-bottom: 15px;
    }

    .inventory-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed var(--border);
    }

    .inventory-item:last-child {
        border-bottom: none;
    }

    .inventory-item .item-name {
        color: var(--dark);
        font-size: 0.95rem;
    }

    .inventory-item .item-stock {
        color: var(--gray);
        font-size: 0.85rem;
    }

    .inventory-item .item-action {
        color: var(--primary);
        font-size: 0.85rem;
        cursor: pointer;
        text-decoration: none;
    }

    .inventory-item .item-action:hover {
        text-decoration: underline;
    }

    /* Top Items Table */
    .items-table {
        width: 100%;
    }

    .items-table thead tr {
        border-bottom: 2px solid var(--border);
    }

    .items-table th {
        padding: 12px 0;
        text-align: left;
        color: var(--gray);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .items-table th:last-child {
        text-align: right;
    }

    .items-table td {
        padding: 15px 0;
        color: var(--dark);
        border-bottom: 1px solid var(--light-gray);
    }

    .items-table td:last-child {
        text-align: right;
        font-weight: 600;
    }

    .items-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <h3>6,569</h3>
            <p>New Maintenance<br>Request</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3>3,569</h3>
            <p>Maintenance Request<br>Pending</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>9,569</h3>
            <p>Maintenance Request<br>Completed</p>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Inventory Card -->
    <div class="card">
        <div class="card-header">
            <h2>Inventory</h2>
            <select class="filter">
                <option>view all</option>
                <option>Low Stock</option>
                <option>Out of Stock</option>
            </select>
        </div>

        <div class="inventory-status">
            <div class="status-header">
                <span>Low in stock</span>
                <span>3 items</span>
            </div>
            <div class="warning">This item is low of stock, please order it soon!</div>
            
            <div class="inventory-item">
                <div>
                    <div class="item-name">Massage Oil</div>
                    <div class="item-stock">Available: 8</div>
                </div>
                <a href="#" class="item-action">Order now !!</a>
            </div>

            <div class="inventory-item">
                <div>
                    <div class="item-name">Hot Gel</div>
                    <div class="item-stock">Available: 3</div>
                </div>
                <a href="#" class="item-action">Order now !!</a>
            </div>
        </div>
    </div>

    <!-- Top Items Card -->
    <div class="card">
        <div class="card-header">
            <h2>Top Item</h2>
            <select class="filter">
                <option>This month</option>
                <option>This week</option>
                <option>Today</option>
            </select>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mask</td>
                    <td>101</td>
                </tr>
                <tr>
                    <td>Massage Oil</td>
                    <td>199</td>
                </tr>
                <tr>
                    <td>Hot Gel</td>
                    <td>125</td>
                </tr>
                <tr>
                    <td>Hand Sanitizer</td>
                    <td>105</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection