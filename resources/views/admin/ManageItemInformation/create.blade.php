@extends('layouts.app')

@section('title', 'Add Inventory Item / Equipment')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    background: linear-gradient(180deg, #f4f6fb 0%, #eef2ff 100%);
    font-family: 'Inter', sans-serif;
}

.main-content-view {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
}

.header-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.maintenance-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.btn-holder {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 14px;
}

.btn-secondary {
    background: #f3f4f6;
    color: #111827;
}
.btn-secondary:hover { background: #e5e7eb; }

.btn-primary {
    background: #26599F;
    color: white;
    box-shadow: 0 6px 14px rgba(38, 89, 159, 0.25);
}
.btn-primary:hover { background: #1a4070; transform: translateY(-1px); }

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1.2fr;
    gap: 20px;
}

.card-box {
    background: white;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
}

.card-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 14px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.form-group label {
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    margin-bottom: 6px;
    display: block;
}

.form-control, .form-select, textarea {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    padding: 10px 12px;
    font-size: 14px;
    outline: none;
}

.form-control:focus, .form-select:focus, textarea:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.full { grid-column: 1 / -1; }

.image-preview-box {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: none;
}

.image-preview-box .placeholder {
    color: #6b7280;
    font-size: 13px;
}

.small-note {
    font-size: 12px;
    color: #6b7280;
    margin-top: 8px;
}

@media (max-width: 900px) {
    .content-grid { grid-template-columns: 1fr; }
    .form-grid { grid-template-columns: 1fr; }
}
/* Custom Dropdown */
.custom-dropdown {
    position: relative;
    font-size: 14px;
}

.dropdown-selected {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 12px;
    background: #f9fafb;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s;
}

.dropdown-selected:hover {
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.dropdown-selected::after {
    content: "\f078"; /* FontAwesome chevron down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-left: 10px;
    font-size: 12px;
}

.dropdown-options {
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    width: 100%;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
    max-height: 150px;
    overflow-y: auto;
    display: none;
    z-index: 100;
}

.dropdown-options li {
    padding: 10px 12px;
    cursor: pointer;
    transition: background 0.2s;
}

.dropdown-options li:hover {
    background: #eef2ff;
}
.required {
    color: #dc2626; /* Red color for required asterisk */
    margin-left: 2px;
}


</style>

<div class="main-content-view">
    <div class="header-title-wrapper">
        <h1 class="maintenance-title">Add Inventory Item / Equipment</h1>

        <div class="btn-holder">
            <a href="{{ route('admin.inventory.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <button type="submit" form="inventoryCreateForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="border-radius:12px;">
            <strong>Fix the errors below:</strong>
            <ul style="margin: 10px 0 0 18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="inventoryCreateForm" action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="content-grid">
            <!-- LEFT: DETAILS -->
            <div class="card-box">
                <div class="card-title">Item / Equipment Details</div>

                <div class="form-grid">
                    <div class="form-group full">
                        <label>Item Name <span class="required">*</label>
                        <input class="form-control" name="itemName" value="{{ old('itemName') }}" placeholder="e.g., Hot/Cold Pack" required>
                    </div>

                    <div class="form-group"> 
                        <label>Category <span class="required">*</label> 
                        @php $cat = strtolower(old('category','')); @endphp 
                        <select class="form-select" name="category" id="categorySelect" required> 
                            <option value="" disabled {{ $cat==='' ? 'selected' : '' }}>Select Category</option> 
                            <option value="item" {{ $cat==='item' ? 'selected' : '' }}>Item</option> 
                            <option value="equipment" {{ $cat==='equipment' ? 'selected' : '' }}>Equipment</option> 
                        </select> 
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input class="form-control" name="status" id="status" value="available" >
                    </div>

                    <!-- ITEM ONLY -->
                    <div id="itemFields" class="full" style="display:none;">
                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap:14px;">
                            <div class="form-group">
                                <label>Quantity <span class="required">*</label>
                                <input class="form-control" name="quantity" id="quantityInput" value="{{ old('quantity') }}" placeholder="e.g., 10">
                            </div>

                            <div class="form-group">
                                <label>Stock Level <span class="required">*</label>
                                <input class="form-control" name="stockLevel" id="stockLevelInput" value="{{ old('stockLevel') }}" placeholder="e.g., 20">
                            </div>
                        </div>
                    </div>

                    <!-- EQUIPMENT ONLY -->
                    <div id="equipmentFields" class="full" style="display:none;">
                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap:14px;">
                            <div class="form-group full">
                                <label>Condition <span class="required">*</label>
                                <input class="form-control" name="condition" id="conditionInput" value="{{ old('condition') }}" placeholder="e.g., good / excellent / fair">
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Description...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT: IMAGE -->
            <div class="card-box">
                <div class="card-title">Item / Equipment Image</div>

                <div class="image-preview-box" id="previewBox">
                    <div class="placeholder" id="previewPlaceholder">No image selected</div>
                    <img id="previewImage" alt="Preview">
                </div>

                <div style="margin-top:14px;">
                    <label style="font-size:11px;font-weight:700;color:#6b7280;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:6px;display:block;">
                        Upload Image
                    </label>
                    <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" id="imageInput">
                    <div class="small-note">Allowed: JPG / PNG / WEBP (max 2MB)</div>
                    <div class="small-note" style="margin-top:6px;">Tip: Upload a clear picture for easier identification.</div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // image preview
    const input = document.getElementById('imageInput');
    const img = document.getElementById('previewImage');
    const placeholder = document.getElementById('previewPlaceholder');

    if (input) {
        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                img.style.display = 'none';
                placeholder.style.display = 'block';
                return;
            }
            const url = URL.createObjectURL(file);
            img.src = url;
            img.style.display = 'block';
            placeholder.style.display = 'none';
        });
    }

    // category toggle
    const category = document.getElementById('categorySelect');
    const itemFields = document.getElementById('itemFields');
    const equipmentFields = document.getElementById('equipmentFields');

    const quantity = document.getElementById('quantityInput');
    const stockLevel = document.getElementById('stockLevelInput');
    const condition = document.getElementById('conditionInput');

    function toggleFields() {
        const val = (category.value || '').toLowerCase();

        if (val === 'item') {
            itemFields.style.display = '';
            equipmentFields.style.display = 'none';

            if (quantity) quantity.required = true;
            if (stockLevel) stockLevel.required = true;
            if (condition) condition.required = false;

            if (condition) condition.value = '';
        } else if (val === 'equipment') {
            itemFields.style.display = 'none';
            equipmentFields.style.display = '';

            if (quantity) quantity.required = false;
            if (stockLevel) stockLevel.required = false;
            if (condition) condition.required = true;

            if (quantity) quantity.value = '';
            if (stockLevel) stockLevel.value = '';
        } else {
            itemFields.style.display = 'none';
            equipmentFields.style.display = 'none';

            if (quantity) quantity.required = false;
            if (stockLevel) stockLevel.required = false;
            if (condition) condition.required = false;
        }
    }

    if (category) {
        category.addEventListener('change', toggleFields);
        toggleFields(); // run once
    }
});

// Custom Dropdown
const dropdownSelected = document.getElementById('dropdownSelected');
const dropdownOptions = document.getElementById('dropdownOptions');
const categoryInput = document.getElementById('categoryInput');

if (dropdownSelected && dropdownOptions && categoryInput) {
    // Show / hide dropdown
    dropdownSelected.addEventListener('click', () => {
        dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
    });

    // Select option
    dropdownOptions.querySelectorAll('li').forEach(option => {
        option.addEventListener('click', () => {
            const value = option.dataset.value;
            dropdownSelected.textContent = option.textContent;
            categoryInput.value = value;
            dropdownOptions.style.display = 'none';
            toggleFields(); // trigger your existing item/equipment fields
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdownSelected.contains(e.target) && !dropdownOptions.contains(e.target)) {
            dropdownOptions.style.display = 'none';
        }
    });

    // Set old value if exists
    @if(old('category'))
        const oldVal = "{{ old('category') }}";
        const oldOption = dropdownOptions.querySelector(`li[data-value='${oldVal}']`);
        if (oldOption) {
            dropdownSelected.textContent = oldOption.textContent;
            categoryInput.value = oldVal;
        }
    @endif
}

</script>
@endsection
