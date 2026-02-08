@extends('layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.edit-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

.edit-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 12px;
}

.edit-title {
    font-size: 28px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 10px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color: #111827;
    font-weight: 700;
    text-decoration: none;
    transition: .2s ease;
}

.back-btn:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

/* GRID like your create page */
.edit-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr;
    gap: 18px;
}

@media (max-width: 992px) {
    .edit-grid { grid-template-columns: 1fr; }
}

.cardx{
    background:#fff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.section-title {
    font-size: 14px;
    font-weight: 900;
    color: #111827;
    margin: 0 0 14px 0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

@media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
}

.form-group { display: flex; flex-direction: column; gap: 6px; }

.form-label {
    font-size: 11px;
    font-weight: 900;
    color:#6b7280;
    text-transform: uppercase;
    letter-spacing: .6px;
}

.form-label.required::after {
    content: " *";
    color: #dc2626;
}

.form-input, .form-select, .form-textarea {
    width:100%;
    border:1px solid #e5e7eb;
    background:#f9fafb;
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
    font-size: 13px;
}

.form-input:focus, .form-select:focus, .form-textarea:focus{
    background:#fff;
    border-color:#26599F;
    box-shadow: 0 0 0 3px rgba(38, 89, 159, .12);
}

.form-textarea { min-height: 90px; resize: vertical; }

/* Image panel */
.img-box {
    border:1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px;
    background:#fff;
}

.img-preview {
    width: 100%;
    height: 240px;
    border-radius: 12px;
    border: 1px solid #eef2f7;
    background: #f8fafc;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.img-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.small-note {
    font-size: 12px;
    color:#6b7280;
}

.btn-save {
    background:#26599F;
    color:#fff;
    border:none;
    font-weight:800;
    border-radius: 10px;
    padding: 10px 16px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
}

.btn-save:hover { background:#1a4070; transform: translateY(-1px); }
</style>

<div class="edit-container">

    <div class="edit-header">
        <h1 class="edit-title">Edit: {{ $item->product_name }}</h1>
        <a href="{{ route('admin.inventory.show', $item->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="edit-grid">
            <!-- LEFT: FORM -->
            <div class="cardx">
                <h3 class="section-title">Item / Equipment Details</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required">Product Code</label>
                        <input type="text" name="product_code" class="form-input"
                               value="{{ old('product_code', $item->product_code) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Product Name</label>
                        <input type="text" name="product_name" class="form-input"
                               value="{{ old('product_name', $item->product_name) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Item" {{ old('category', $item->category) == 'Item' ? 'selected' : '' }}>Item</option>
                            <option value="Equipment" {{ old('category', $item->category) == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status', $item->status) == 'available' ? 'selected' : '' }}>available</option>
                            <option value="in-use" {{ old('status', $item->status) == 'in-use' ? 'selected' : '' }}>in-use</option>
                            <option value="maintenance" {{ old('status', $item->status) == 'maintenance' ? 'selected' : '' }}>maintenance</option>
                            <option value="out-of-stock" {{ old('status', $item->status) == 'out-of-stock' ? 'selected' : '' }}>out-of-stock</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-input"
                               value="{{ old('quantity', $item->quantity) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-input"
                               value="{{ old('unit', $item->unit) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-input"
                               value="{{ old('brand', $item->brand) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-input"
                               value="{{ old('model', $item->model) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Serial Number</label>
                        <input type="text" name="serial_number" class="form-input"
                               value="{{ old('serial_number', $item->serial_number) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-input"
                               value="{{ old('location', $item->location) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea">{{ old('description', $item->description) }}</textarea>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea">{{ old('notes', $item->notes) }}</textarea>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>

            <!-- RIGHT: IMAGE -->
            <div class="cardx">
                <h3 class="section-title">Item / Equipment Image</h3>

                <div class="img-box">
                    <div class="img-preview" id="imgPreview">
                        @if(!empty($item->image_path))
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="Item Image">
                        @else
                            <div class="small-note">No image uploaded</div>
                        @endif
                    </div>

                    <div style="margin-top:12px;">
                        <label class="form-label">Replace Image</label>
                        <input type="file" name="image" id="imageInput" class="form-input" accept="image/*">
                        <div class="small-note" style="margin-top:6px;">Allowed: JPG / PNG / WEBP (max 2MB)</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const input = document.getElementById('imageInput');
const preview = document.getElementById('imgPreview');

if (input) {
    input.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
