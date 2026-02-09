@extends('layouts.app')

@section('title', 'Edit Maintenance Request')

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

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

/* ================= LAYOUT GRID ================= */
.request-detail-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

@media (max-width: 900px) {
    .request-detail-wrapper {
        grid-template-columns: 1fr;
    }
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

/* ================= INFO ITEMS ================= */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}

.info-label {
    font-size: 12px;
    text-transform: uppercase;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

.info-box {
    background: #f9fafb;
    padding: 14px 16px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
    color: #374151;
}

.info-box.large {
    min-height: 100px;
    line-height: 1.6;
}

/* ================= STATUS DROPDOWN ================= */
.status-dropdown {
    width: 100%;
    padding: 12px 16px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    background-color: white;
    font-size: 14px;
    color: #1f2937;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 16px;
}

.status-dropdown:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* ================= IMAGES ================= */
.main-img-container {
    margin-bottom: 20px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    /* Added for centering placeholder */
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    background-color: #f9fafb;
}

.main-img-container img {
    width: 100%;
    height: auto;
    max-height: 400px; 
    object-fit: contain;
    display: block;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.main-img-container img:hover {
    transform: scale(1.02);
}

.thumbnail-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.thumbnail-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
}

.thumbnail-img:hover {
    border-color: #3b82f6;
}

/* ================= MODAL ================= */
.modal-overlay {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.modal-overlay.show { display: flex; }

.modal-img {
    max-width: 90%;
    max-height: 90vh;
    border-radius: 8px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close-modal:hover { color: #fca5a5; }

</style>

<div class="main-content-view">
    <form action="{{ route('admin.maintenance.update', $request->requestID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="header-title-wrapper">
            <div class="maintenance-title">Edit Maintenance Request</div>
            <div class="btn-holder">
                <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>

        <div class="request-detail-wrapper">
            
            <div class="content-card">
                <h2 class="section-title">Equipment Maintenance Details</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Request ID</span>
                        <div class="info-box">{{ $request->requestID }}</div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Equipment</span>
                        @foreach($request->itemMaintenances as $item)
                        <div class="info-box">{{ $item->itemInfo->itemName ?? 'N/A' }}</div>
                        @endforeach
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date Submitted</span>
                        <div class="info-box">{{ $request->dateSubmitted->format('d/m/Y h:i A') }}</div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Issue</span>
                        @foreach($request->itemMaintenances as $item)
                        <div class="info-box">{{ $item->itemIssue ?? 'N/A' }}</div>
                        @endforeach
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <span class="info-label">Details</span>
                    @foreach($request->itemMaintenances as $item)
                    <div class="info-box large">{{ $item->detailsMaintenance ?? 'No details provided.' }}</div>
                    @endforeach
                </div>

                <div style="background: #f0f9ff; padding: 20px; border-radius: 12px; border: 1px solid #bae6fd;">
                    <span class="info-label" style="color: #0369a1;">Update Status</span>
                    <select name="status" class="status-dropdown">
                        @php $currentStatus = $request->status; @endphp
                        <option value="Pending" {{ $currentStatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ $currentStatus == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ $currentStatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ $currentStatus == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Cancelled" {{ $currentStatus == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #e5e7eb;">

                <h3 class="section-title">Submitted By</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">User ID</span>
                        <div class="info-box">{{ $request->userID }}</div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">User Name</span>
                        <div class="info-box">{{ $request->user->name ?? 'Unknown' }}</div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h3 class="section-title">Equipment Images</h3>
                
                <div class="main-img-container">
                    @php 
                        $images = $request->images;
                    @endphp

                    @if($images->isNotEmpty())
                        @php 
                            $mainImg = asset('storage/' . $images->first()->imagePath);
                        @endphp
                        <img src="{{ $mainImg }}" id="main-preview-img" onclick="viewImage(this.src)" alt="Main Image">
                    @else
                        <div style="text-align: center; color: #9ca3af; padding: 40px;">
                            <i class="fas fa-image" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p style="font-weight: 500; font-size: 16px; margin: 0;">No attachment image</p>
                            <span style="font-size: 13px; opacity: 0.7;">The requester did not upload any photos.</span>
                        </div>
                    @endif
                </div>

                @if($images->isNotEmpty())
                    <span class="info-label" style="margin-top: 20px;">Additional Images</span>
                    <div class="thumbnail-grid">
                        @foreach($images as $img)
                            <img src="{{ asset('storage/' . $img->imagePath) }}" 
                                 class="thumbnail-img" 
                                 onclick="swapImage(this.src)">
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </form>
</div>

<div id="imgModal" class="modal-overlay" onclick="closeModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-img" id="modalImage">
</div>

<script>
    function swapImage(src) {
        document.getElementById('main-preview-img').src = src;
    }

    function viewImage(src) {
        document.getElementById("modalImage").src = src;
        document.getElementById("imgModal").classList.add("show");
    }

    function closeModal() {
        document.getElementById("imgModal").classList.remove("show");
    }
</script>
@endsection