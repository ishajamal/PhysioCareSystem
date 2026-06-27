@extends('layouts.app')

@section('title', 'Account Approval')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

/* ================= CONTAINER ================= */
.main-content-view {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
}

/* ================= HEADER ================= */
.header-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.maintenance-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.subtitle {
    color: #6b7280;
    font-size: 14px;
    margin-top: 6px;
}

.btn-holder {
    display: flex;
    gap: 15px;
}

/* ================= BUTTONS ================= */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 14px;
}

.btn-secondary {
    background-color: #f0f0f0;
    color: #333;
}

.btn-secondary:hover {
    background-color: #e5e5e5;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.btn-success {
    background-color: #10b981;
    color: white;
}

.btn-success:hover {
    background-color: #059669;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

/* ================= CONTENT CARDS ================= */
.content-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.section-title {
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.25rem;
    color: #1f2937;
}

/* ================= TABLE ================= */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.approval-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.approval-table th {
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6b7280;
    padding: 14px 16px;
    border-bottom: 2px solid #e5e7eb;
    background: #fafbfc;
    font-weight: 700;
}

.approval-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}

.approval-table tbody tr {
    transition: background 0.2s ease;
}

.approval-table tbody tr:hover {
    background: #fafbfc;
}

.approval-table tbody tr:last-child td {
    border-bottom: none;
}

/* ================= USER INFO ================= */
.user-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.user-name {
    font-weight: 700;
    color: #111827;
    font-size: 14px;
}

.user-email {
    font-size: 13px;
    color: #6b7280;
}

/* ================= BADGES ================= */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 80px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.badge-pending {
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid rgba(194, 65, 12, 0.12);
}

.badge-pending::before {
    content: "⏳";
    font-size: 13px;
}

.badge-approved {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid rgba(4, 120, 87, 0.12);
}

.badge-approved::before {
    content: "✓";
    font-weight: 800;
    font-size: 14px;
}

/* ================= STATUS STYLES ================= */
.status-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #374151;
}

.status-dot {
    height: 10px;
    width: 10px;
    border-radius: 50%;
    display: inline-block;
}

.status-pending { background-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2); }
.status-approved { background-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2); }

/* ================= BUTTONS ================= */
.btn-approve {
    background-color: #10b981;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-approve:hover {
    background-color: #059669;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    transform: translateY(-1px);
}

.btn-approve:active {
    transform: scale(0.97);
}

.btn-disabled {
    background-color: #e5e7eb;
    color: #9ca3af;
    border: none;
    border-radius: 10px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 700;
    cursor: default;
}

/* ================= EMPTY STATE ================= */
.empty-box {
    text-align: center;
    padding: 60px 20px 50px;
    color: #6b7280;
}

.empty-box .icon-circle {
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 34px;
    color: #9ca3af;
}

.empty-box h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.empty-box p {
    font-size: 15px;
    color: #6b7280;
    max-width: 380px;
    margin: 0 auto;
    line-height: 1.5;
}

/* ================= ALERT ================= */
.success-alert {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
    padding: 14px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
}

.success-alert i {
    font-size: 18px;
    color: #10b981;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 900px) {
    .header-title-wrapper {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .btn-holder {
        width: 100%;
    }
    
    .btn-holder .btn {
        flex: 1;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .main-content-view {
        padding: 24px 16px;
    }

    .maintenance-title {
        font-size: 26px;
    }

    .content-card {
        padding: 20px 16px;
        border-radius: 16px;
    }

    .approval-table th,
    .approval-table td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .approval-table {
        font-size: 13px;
    }

    .user-email {
        font-size: 12px;
    }

    .badge {
        font-size: 11px;
        padding: 4px 10px;
    }

    .btn-approve {
        padding: 7px 14px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .approval-table td {
        font-size: 12px;
        padding: 10px 8px;
    }

    .user-name {
        font-size: 13px;
    }

    .badge {
        font-size: 10px;
        padding: 3px 8px;
    }

    .btn-approve {
        padding: 6px 12px;
        font-size: 11px;
    }
}
.module-tabs {
    display: flex;
    gap: 25px;
    border-bottom: 2px solid #e5e7eb;
    margin-top: 18px;
    margin-bottom: 28px;
}

.module-tab {
    padding: 14px 22px;
    text-decoration: none;
    color: #6b7280;
    font-weight: 700;
    font-size: 16px;
    border-radius: 10px 10px 0 0;
    border-bottom: 3px solid transparent;
}

.module-tab:hover {
    background: #f3f4f6;
    color: #26599F;
}

.module-tab.active {
    background: #eff6ff;
    color: #2563eb;
    border-bottom-color: #2563eb;
}
</style>

<div class="main-content-view">
    <div class="header-title-wrapper">
        <div>
            <div class="maintenance-title">Manage Users</div>

            <div class="module-tabs">
                <a href="{{ route('admin.manage.user') }}" class="module-tab">
                    User List
                </a>

                <a href="{{ route('admin.manage.user.account.approval') }}" class="module-tab active">
                    Account Approval
                </a>
            </div>

            <div class="subtitle">
                <i class="fas fa-user-shield" style="margin-right: 6px; color: #6b7280;"></i>
                Review and approve therapist account registrations
            </div>
        </div>

        <div class="btn-holder">
            <span style="background: #f3f4f6; padding: 10px 20px; border-radius: 12px; font-weight: 600; color: #374151; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-users" style="color: #6b7280;"></i>
                {{ $therapists->count() }} pending
            </span>
        </div>
    </div>

    <!-- ================= CONTENT CARD ================= -->
    <div class="content-card">
        @if(session('success'))
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($therapists->count() > 0)
            <div class="table-wrapper">
                <table class="approval-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Therapist Details</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($therapists as $therapist)
                            <tr>
                                <td>
                                    <span style="font-weight: 600; color: #3b82f6;">
                                        #{{ $therapist->userID }}
                                    </span>
                                </td>

                                <td>
                                    <div class="user-info">
                                        <span class="user-name">{{ $therapist->name }}</span>
                                        <span class="user-email">{{ $therapist->email }}</span>
                                    </div>
                                </td>

                                <td>{{ $therapist->phoneNumber ?? '—' }}</td>

                                <td>
                                    <span style="background: #f3f4f6; padding: 4px 12px; border-radius: 30px; font-size: 12px; font-weight: 600; color: #374151;">
                                        {{ ucfirst($therapist->role) }}
                                    </span>
                                </td>

                                <td>
                                    @if($therapist->is_approved)
                                        <span class="badge badge-approved">Approved</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!$therapist->is_approved)
                                        <form method="POST" action="{{route('admin.manage.user.account.approval.approve', $therapist->userID) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-approve">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn-disabled">
                                            <i class="fas fa-check-circle"></i> Approved
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-box">
                <div class="icon-circle">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>No Pending Accounts</h3>
                <p>There are currently no therapist accounts waiting for approval.</p>
            </div>
        @endif
    </div>
</div>
@endsection