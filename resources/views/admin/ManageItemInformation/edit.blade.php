@extends('layouts.app')

@section('title', 'Edit Inventory Item / Equipment')

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

.btn-secondary { background: #f3f4f6; color: #111827; }
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

.image-box {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
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
</style>

<div class="main-content-view">
    <div class="header-title-wrapper">
        <h1 class="maintenance-title">Edit: {{ $item->itemName }}</h1>

        <div class="btn-holder">
            <a href="{{ route('admin.inventory.show', $item->itemID) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <button type="submit" form="inventoryEditForm" class="btn btn-primary">
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

    <form id="inventoryEditForm" action="{{ route('admin.inventory.update', $item->itemID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-grid">
            <!-- LEFT -->
            <div class="card-box">
                <div class="card-title">Item / Equipment Details</div>

                <div class="form-grid">
                    <div class="form-group full">
                        <label>Item Name *</label>
                        <input class="form-control" name="itemName"
                               value="{{ old('itemName', $item->itemName) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Category *</label>
                        @php $cat = strtolower(old('category', $item->category)); @endphp
                        <select class="form-select" name="category" id="categorySelect" required>
                            <option value="item" {{ $cat==='item' ? 'selected' : '' }}>Item</option>
                            <option value="equipment" {{ $cat==='equipment' ? 'selected' : '' }}>Equipment</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        @php $status = old('status', $item->status ?? 'available'); @endphp
                        <select class="form-select" name="status">
                            <option value="available" {{ $status==='available' ? 'selected' : '' }}>available</option>
                            <option value="under maintenance" {{ $status==='under maintenance' ? 'selected' : '' }}>under maintenance</option>
                            <option value="unavailable" {{ $status==='unavailable' ? 'selected' : '' }}>unavailable</option>
                        </select>
                    </div>

                    <!-- ITEM ONLY -->
                    <div id="itemFields" class="full" style="display:none;">
                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap:14px;">
                            <div class="form-group">
                                <label>Quantity *</label>
                                <input class="form-control" name="quantity" id="quantityInput"
                                       value="{{ old('quantity', $item->quantity) }}">
                            </div>

                            <div class="form-group">
                                <label>Stock Level *</label>
                                <input class="form-control" name="stockLevel" id="stockLevelInput"
                                       value="{{ old('stockLevel', $item->stockLevel) }}">
                            </div>
                        </div>
                    </div>

                    <!-- EQUIPMENT ONLY -->
                    <div id="equipmentFields" class="full" style="display:none;">
                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap:14px;">
                            <div class="form-group full">
                                <label>Condition *</label>
                                <input class="form-control" name="condition" id="conditionInput"
                                       value="{{ old('condition', $item->condition) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="card-box">
                <div class="card-title">Item / Equipment Image</div>

                <div class="image-box" id="previewBox">
                    @if($imageUrl)
                        <img id="previewImage" src="{{ $imageUrl }}" alt="Item Image">
                    @else
                        <img id="previewImage" alt="Item Image" style="display:none;">
                        <div class="small-note" id="previewPlaceholder">No image selected</div>
                    @endif
                </div>

                <div style="margin-top:14px;">
                    <label style="font-size:11px;font-weight:700;color:#6b7280;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:6px;display:block;">
                        Replace Image
                    </label>
                    <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" id="imageInput">
                    <div class="small-note">Allowed: JPG / PNG / WEBP (max 2MB)</div>
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
            if (!file) return;
            const url = URL.createObjectURL(file);
            img.src = url;
            img.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
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
        } else {
            itemFields.style.display = 'none';
            equipmentFields.style.display = '';

            if (quantity) quantity.required = false;
            if (stockLevel) stockLevel.required = false;
            if (condition) condition.required = true;

            if (quantity) quantity.value = '';
            if (stockLevel) stockLevel.value = '';
        }
    }

    if (category) {
        category.addEventListener('change', toggleFields);
        toggleFields();
    }
});
</script>
@endsection