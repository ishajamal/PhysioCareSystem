@extends('layouts.app')

@section('title', 'Generate Report')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.page-wrap {
    font-family: 'Inter', sans-serif;
    padding: 25px 10px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}

.page-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.btn-back {
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color: #111827;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-save {
    background: #26599F;
    color: #fff;
    border: none;
    font-weight: 700;
    border-radius: 10px;
    padding: 10px 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.btn-save:hover {
    background: #1a4070;
    transform: translateY(-2px);
}

.card-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 25px;
    max-width: 800px;
    margin: 0 auto;
}

.card-title {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.label {
    font-size: 11px;
    font-weight: 800;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 8px;
    display: block;
}

.inputx, .selectx {
    width: 100%;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    border-radius: 10px;
    padding: 10px 12px;
    outline: none;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
}

.inputx:focus, .selectx:focus {
    background: #fff;
    border-color: #26599F;
    box-shadow: 0 0 0 3px rgba(38, 89, 159, 0.12);
}

.date-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.checkbox-section {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 15px;
    background: #f9fafb;
    margin-top: 10px;
}

.checkbox-title {
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    border-radius: 4px;
}

.checkbox-item label {
    font-size: 13px;
    color: #374151;
    margin: 0;
    cursor: pointer;
    user-select: none;
}

.hidden-section {
    display: none;
}

.visible-section {
    display: block;
}

.button-group {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 25px;
}

.small-note {
    font-size: 12px;
    color: #6b7280;
    margin-top: 5px;
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

.btn-primary {
    background-color: #3b82f6;
    color: white;
}
/*  */
.btn-primary:hover {
    background-color: #2563eb;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}
</style>

<div class="page-wrap">
    <div class="top-bar">
        <div>
            <h1 class="page-title">Generate Report</h1>
        </div>
        <!-- <a href="{{ route('admin.reports.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a> -->
    </div>

    <div class="card-box">
        <form id="reportForm" action="{{ route('admin.reports.store') }}" method="POST">
            @csrf

            <!-- Report Type Selection -->
            <div class="form-group">
                <label class="label">Report Type *</label>
                <select class="selectx" name="reportType" id="reportType" required onchange="updateCheckboxes()">
                    <option value="">-- Select Report Type --</option>
                    <option value="usage" {{ old('reportType') === 'usage' ? 'selected' : '' }}>Usage Report</option>
                    <option value="maintenance" {{ old('reportType') === 'maintenance' ? 'selected' : '' }}>Maintenance Report</option>
                </select>
                @error('reportType') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Usage Report Columns -->
            <div id="usageCheckboxes" class="hidden-section">
                <div class="checkbox-section">
                    <div class="checkbox-title">Select columns to include in Usage Report:</div>
                    <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="no" id="usage_no" checked>
                            <label for="usage_no">No</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="usageID" id="usage_id" checked>
                            <label for="usage_id">Usage ID</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="itemID" id="usage_item_id" checked>
                            <label for="usage_item_id">Item ID</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="itemName" id="usage_item_name" checked>
                            <label for="usage_item_name">Item Name</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="quantity" id="usage_quantity" checked>
                            <label for="usage_quantity">Quantity</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="usedBy" id="usage_used_by" checked>
                            <label for="usage_used_by">Used By</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="usage_columns[]" value="usedDate" id="usage_used_date" checked>
                            <label for="usage_used_date">Used Date</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Report Columns -->
            <div id="maintenanceCheckboxes" class="hidden-section">
                <div class="checkbox-section">
                    <div class="checkbox-title">Select columns to include in Maintenance Report:</div>
                    <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="no" id="maint_no" checked>
                            <label for="maint_no">No</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="requestID" id="maint_request_id" checked>
                            <label for="maint_request_id">Request ID</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="itemID" id="maint_item_id" checked>
                            <label for="maint_item_id">Item ID</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="equipmentName" id="maint_equip_name" checked>
                            <label for="maint_equip_name">Equipment Name</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="itemIssue" id="maint_issue" checked>
                            <label for="maint_issue">Item Issue</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="submittedBy" id="maint_submitted_by" checked>
                            <label for="maint_submitted_by">Submitted By</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="status" id="maint_status" checked>
                            <label for="maint_status">Status</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="dateSubmitted" id="maint_date_submitted" checked>
                            <label for="maint_date_submitted">Date Submitted</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="maintenance_columns[]" value="detailsMaintenance" id="maint_details" checked>
                            <label for="maint_details">Details Maintenance</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="form-group" style="margin-top: 25px;">
                <label class="label">Date Range</label>
                <div class="date-row">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px; display: block;">Start Date</label>
                        <input type="date" class="inputx" name="dateStart" id="dateStart" value="{{ old('dateStart') }}">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px; display: block;">End Date</label>
                        <input type="date" class="inputx" name="dateEnd" id="dateEnd" value="{{ old('dateEnd') }}">
                    </div>
                </div>
                <div class="small-note">Leave empty to include all dates</div>
            </div>

            <!-- Submit Button -->
            <div class="button-group">
                <a href="{{ route('admin.reports.dashboard') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-csv"></i> Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateCheckboxes() {
    const reportType = document.getElementById('reportType').value;
    const usageSection = document.getElementById('usageCheckboxes');
    const maintenanceSection = document.getElementById('maintenanceCheckboxes');

    if (reportType === 'usage') {
        usageSection.classList.remove('hidden-section');
        usageSection.classList.add('visible-section');
        maintenanceSection.classList.remove('visible-section');
        maintenanceSection.classList.add('hidden-section');
    } else if (reportType === 'maintenance') {
        maintenanceSection.classList.remove('hidden-section');
        maintenanceSection.classList.add('visible-section');
        usageSection.classList.remove('visible-section');
        usageSection.classList.add('hidden-section');
    } else {
        usageSection.classList.remove('visible-section');
        usageSection.classList.add('hidden-section');
        maintenanceSection.classList.remove('visible-section');
        maintenanceSection.classList.add('hidden-section');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCheckboxes();
});
</script>
@endsection
