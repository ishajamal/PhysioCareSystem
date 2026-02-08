@extends('layouts.therapist')

@section('title', 'Therapist Dashboard')

@section('content')
<style>
    .analytics-section {
        margin-bottom: 40px;
    }

    .analytics-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 25px;
        font-family: 'Poppins', sans-serif;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(99, 135, 194, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(99, 135, 194, 0.1), rgba(99, 135, 194, 0.05));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .stat-icon i {
        font-size: 28px;
        color: var(--primary);
    }

    .stat-number {
        font-size: 42px;
        font-weight: 700;
        color: var(--gray-900);
        margin: 10px 0;
        font-family: 'Poppins', sans-serif;
    }

    .stat-label {
        font-size: 16px;
        color: var(--gray-600);
        font-weight: 500;
    }

    .history-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .history-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--gray-200);
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--gray-200);
    }

    .history-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--gray-800);
        font-family: 'Poppins', sans-serif;
    }

    .filter-dropdown {
        padding: 8px 15px;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        font-size: 14px;
        color: var(--gray-700);
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-dropdown:hover {
        border-color: var(--primary);
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table thead {
        background: var(--gray-50);
    }

    .history-table th {
        padding: 12px 15px;
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-700);
        border-bottom: 2px solid var(--gray-200);
    }

    .history-table td {
        padding: 15px;
        font-size: 14px;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
    }

    .history-table tbody tr {
        transition: all 0.2s ease;
    }

    .history-table tbody tr:hover {
        background: var(--gray-50);
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-repaired {
        background: rgba(102, 187, 106, 0.1);
        color: var(--success);
    }

    .status-ongoing {
        background: rgba(255, 167, 38, 0.1);
        color: var(--warning);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 1024px) {
        .history-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .history-card {
            padding: 20px;
        }

        .history-table {
            font-size: 13px;
        }

        .history-table th,
        .history-table td {
            padding: 10px 8px;
        }
    }
</style>

<div class="analytics-section">
    <h2 class="analytics-title">Analytics</h2>
    
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div class="stat-number">120</div>
            <div class="stat-label">Maintenance Submitted</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-clipboard-data"></i>
            </div>
            <div class="stat-number">310</div>
            <div class="stat-label">Usage Recorded</div>
        </div>
    </div>
</div>

<div class="history-section">
    <!-- History Usage Record -->
    <div class="history-card">
        <div class="history-header">
            <h3 class="history-title">History Usage Record</h3>
            <select class="filter-dropdown">
                <option>This month</option>
                <option>Last month</option>
                <option>Last 3 months</option>
                <option>This year</option>
            </select>
        </div>

        <table class="history-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Glove</td>
                    <td style="text-align: center;">3</td>
                    <td style="text-align: right;">27.9.2024</td>
                </tr>
                <tr>
                    <td>Bed Sheet</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: right;">27.9.2024</td>
                </tr>
                <tr>
                    <td>Essential Oil</td>
                    <td style="text-align: center;">2</td>
                    <td style="text-align: right;">26.9.2024</td>
                </tr>
                <tr>
                    <td>Kinesiology Tape</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: right;">26.9.2024</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- History Maintenance Request -->
    <div class="history-card">
        <div class="history-header">
            <h3 class="history-title">History Maintenance Request</h3>
            <select class="filter-dropdown">
                <option>This month</option>
                <option>Last month</option>
                <option>Last 3 months</option>
                <option>This year</option>
            </select>
        </div>

        <table class="history-table">
            <thead>
                <tr>
                    <th>Equipment Name</th>
                    <th style="text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Treadmill</td>
                    <td style="text-align: right;">
                        <span class="status-badge status-repaired">Repaired</span>
                    </td>
                </tr>
                <tr>
                    <td>Dumbell</td>
                    <td style="text-align: right;">
                        <span class="status-badge status-ongoing">On Going</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection