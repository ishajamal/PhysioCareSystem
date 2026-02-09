@extends('layouts.app')

@section('title', 'Maintenance Request Details')

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
}

.main-img-container img {
    width: 100%;
    height: auto;
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
    <div class="header-title-wrapper">
        <div class="maintenance-title">Maintenance Request Details</div>
        <div class="btn-holder">
            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button class="btn btn-danger" onclick="openModal('deleteModal{{ $request->requestID }}')">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </div>
    </div>

    <!-- FLEX WRAPPER FOR CARDS -->
    <div class="content-cards-wrapper" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <!-- LEFT CARD: Details -->
        <div class="content-card" style="flex: 2 1 0;">
            <h3 class="section-title">Equipment Maintenance Details</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Request ID</span>
                    <div class="info-box">{{ $request->requestID }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Equipment</span>
                    <div class="info-box">{{ $request->itemInfo->itemName ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Date Submitted</span>
                    <div class="info-box">{{ $request->maintenanceRequest->dateSubmitted->format('d/m/Y h:i A') }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Issue</span>
                    <div class="info-box">{{ $request->itemIssue }}</div>
                </div>
            </div>

            <div class="info-item">
                <span class="info-label">Details</span>
                <div class="info-box large">{{ $request->detailsMaintenance ?? 'No additional details.' }}</div>
            </div>

            <div style="margin-top: 25px;">
                <span class="info-label">Status</span>
                <div style="padding: 15px 20px; background: #f9fafb; border-radius: 12px; display: inline-flex; align-items: center;">
                    @php $statusClass = strtolower(str_replace(' ', '-', $request->maintenanceRequest->status)); @endphp
                    <div class="status-label">
                        <span class="status-dot status-{{ $statusClass }}"></span> 
                        {{ ucfirst($request->maintenanceRequest->status) }}
                    </div>
                </div>
            </div>

            <hr style="margin: 30px 0; border: 0; border-top: 1px solid #e5e7eb;">

            <h3 class="section-title">Submitted By</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">User ID</span>
                    <div class="info-box">{{ $request->maintenanceRequest->userID }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label">User Name</span>
                    <div class="info-box">{{ $request->maintenanceRequest->user->name ?? 'Unknown' }}</div>
                </div>
            </div>
        </div>

        <!-- RIGHT CARD: Images -->
        <div class="content-card" style="flex: 1 1 0;">
            <h3 class="section-title">Equipment Images</h3>
            <div class="main-img-container">
                @php 
                    $images = $request->maintenanceRequest->images;
                    $mainImg = $images->first() ? asset('storage/' . $images->first()->imagePath) : asset('images/placeholder.jpg');
                @endphp
                <img src="{{ $mainImg }}" id="equipment-img" onclick="viewImage(this.src)" alt="Main Image">
            </div>
            
            <span class="info-label" style="margin-top: 20px;">Additional Images</span>
            <div class="thumbnail-grid">
                @forelse($images as $img)
                    <img src="{{ asset('storage/' . $img->imagePath) }}" class="thumbnail-img" onclick="viewImage(this.src)">
                @empty
                    <span style="color: #9ca3af; font-style: italic;">No additional images uploaded</span>
                @endforelse
            </div>
        </div>
    </div>
</div>


<!-- IMAGE VIEWER MODAL -->
<div id="imgModal" onclick="closeImageModal()">
    <div style="position: relative; max-width: 90%; max-height: 90vh;" onclick="event.stopPropagation()">
        <img id="modalImage" style="max-width: 100%; border-radius: 12px;">
    </div>
</div>

<x-delete-modal
    id="deleteModal{{ $request->requestID }}"
    title="DELETE THIS RECORD?"
    message="Are you sure you want to delete Request #{{ $request->requestID }}?"
    route="{{ route('admin.maintenance.destroy', $request->requestID) }}"
    method="DELETE"
/>

<script>
    // 1. Function to OPEN delete modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        
        if (modal) {
            modal.classList.remove('hidden'); 
            modal.classList.add('show');
            
            var checkbox = document.getElementById('confirmCheck' + modalId);
            var deleteBtn = document.getElementById('deleteBtn' + modalId);

            if (checkbox && deleteBtn) {
                checkbox.checked = false;
                deleteBtn.disabled = true;

                checkbox.onchange = function() {
                    deleteBtn.disabled = !this.checked;
                };
            }
        } else {
            console.error('Modal not found: ' + modalId);
        }
    }

    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.classList.add('hidden'); 
        }
    }

    function viewImage(src) {
        document.getElementById("modalImage").src = src;
        document.getElementById("imgModal").classList.add("show");
    }

    function closeImageModal() {
        document.getElementById("imgModal").classList.remove("show");
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay') && 
            event.target.id && event.target.id.startsWith('deleteModal')) {
            event.target.classList.remove('show');
            event.target.classList.add('hidden');
        }
    }
</script>
@endsection