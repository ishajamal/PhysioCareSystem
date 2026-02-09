@extends('layouts.app')

@section('title', 'Add Inventory')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.page-wrap{
    font-family: 'Inter', sans-serif;
    padding: 25px 10px;
}

.top-bar{
    display:flex;
    justify-content: space-between;
    align-items:center;
    gap: 12px;
    margin-bottom: 18px;
}

.page-title{
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.btn-back{
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color:#111827;
    font-weight:600;
    border-radius: 10px;
    padding: 10px 14px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.btn-save{
    background:#26599F;
    color:#fff;
    border:none;
    font-weight:700;
    border-radius: 10px;
    padding: 10px 16px;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.grid{
    display:grid;
    grid-template-columns: 1.8fr 1fr;
    gap: 18px;
}

.cardx{
    background:#fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    padding: 18px;
}

.card-title{
    font-size: 14px;
    font-weight: 800;
    color:#111827;
    margin-bottom: 12px;
}

.label{
    font-size: 11px;
    font-weight: 800;
    color:#6b7280;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 6px;
}

.inputx, .selectx, .textareax{
    width:100%;
    border:1px solid #e5e7eb;
    background:#f9fafb;
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
    font-size: 13px;
}

.inputx:focus, .selectx:focus, .textareax:focus{
    background:#fff;
    border-color:#26599F;
    box-shadow: 0 0 0 3px rgba(38, 89, 159, .12);
}

.row2{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.img-box{
    border:1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px;
    background:#fff;
}

.img-preview{
    width: 100%;
    height: 220px;
    border-radius: 12px;
    border: 1px solid #eef2f7;
    background: #f8fafc;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.img-preview img{
    width:100%;
    height:100%;
    object-fit: contain;
}

.small-note{
    font-size: 12px;
    color:#6b7280;
    margin-top: 10px;
}

@media(max-width: 992px){
    .grid{ grid-template-columns: 1fr; }
}
</style>

<div class="page-wrap">
    <div class="top-bar">
        <div>
            <h1 class="page-title">Add Inventory Item / Equipment</h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.inventory.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            {{-- Save button triggers submit --}}
            <button type="submit" form="inventoryForm" class="btn-save">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>

    <form id="inventoryForm" action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid">
            {{-- LEFT: DETAILS --}}
            <div class="cardx">
                <div class="card-title">Item / Equipment Details</div>

                <div class="row2">
                    <div>
                        <div class="label">Product Code *</div>
                        <input class="inputx" name="product_code" value="{{ old('product_code') }}" placeholder="e.g., C023" required>
                        @error('product_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <div class="label">Product Name *</div>
                        <input class="inputx" name="product_name" value="{{ old('product_name') }}" placeholder="e.g., Hot Gel" required>
                        @error('product_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2 mt-3">
                    <div>
                        <div class="label">Category *</div>
                        <select class="selectx" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Item" {{ old('category')==='Item' ? 'selected' : '' }}>Item</option>
                            <option value="Equipment" {{ old('category')==='Equipment' ? 'selected' : '' }}>Equipment</option>
                        </select>
                        @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <div class="label">Status *</div>
                        <select class="selectx" name="status" required>
                            <option value="available" {{ old('status','available')==='available' ? 'selected' : '' }}>available</option>
                            <option value="in-use" {{ old('status')==='in-use' ? 'selected' : '' }}>in-use</option>
                            <option value="maintenance" {{ old('status')==='maintenance' ? 'selected' : '' }}>maintenance</option>
                            <option value="out-of-stock" {{ old('status')==='out-of-stock' ? 'selected' : '' }}>out-of-stock</option>
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2 mt-3">
                    <div>
                        <div class="label">Quantity</div>
                        <input type="number" class="inputx" name="quantity" value="{{ old('quantity') }}" min="0" placeholder="e.g., 10">
                        @error('quantity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <div class="label">Unit</div>
                        <input class="inputx" name="unit" value="{{ old('unit') }}" placeholder="e.g., bottle / unit / piece">
                        @error('unit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2 mt-3">
                    <div>
                        <div class="label">Brand</div>
                        <input class="inputx" name="brand" value="{{ old('brand') }}" placeholder="e.g., PhysioCare">
                        @error('brand') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <div class="label">Model</div>
                        <input class="inputx" name="model" value="{{ old('model') }}" placeholder="e.g., HG-200">
                        @error('model') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2 mt-3">
                    <div>
                        <div class="label">Serial Number</div>
                        <input class="inputx" name="serial_number" value="{{ old('serial_number') }}" placeholder="(Optional)">
                        @error('serial_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <div class="label">Location</div>
                        <input class="inputx" name="location" value="{{ old('location') }}" placeholder="e.g., Storage Room">
                        @error('location') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <div class="label">Description</div>
                    <textarea class="textareax" name="description" rows="3" placeholder="Description...">{{ old('description') }}</textarea>
                    @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mt-3">
                    <div class="label">Notes</div>
                    <textarea class="textareax" name="notes" rows="3" placeholder="Notes...">{{ old('notes') }}</textarea>
                    @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- RIGHT: IMAGE --}}
            <div class="cardx">
                <div class="card-title">Item / Equipment Image</div>

                <div class="img-box">
                    <div class="img-preview" id="imgPreview">
                        <span class="small-note">No image selected</span>
                    </div>

                    <div class="mt-3">
                        <div class="label">Upload Image</div>
                        <input class="inputx" type="file" name="image" id="imageInput" accept="image/*">
                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        <div class="small-note">Allowed: JPG / PNG / WEBP (max 2MB)</div>
                    </div>
                </div>

                <div class="small-note mt-3">Tip: Upload a clear picture for easier identification.</div>
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
        if (!file) {
            preview.innerHTML = '<span class="small-note">No image selected</span>';
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
