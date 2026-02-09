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

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
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
.status-in-progress { background-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2); }
.status-completed { background-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2); }
.status-rejected { background-color: #ef4444; box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2); }

/* ================= IMAGES ================= */
.main-img-container {
    margin-bottom: 20px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    /* Added for centering the 'No Image' text */
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    background-color: #f9fafb;
}

.main-img-container img {
    width: 100%;
    height: auto;
    max-height: 400px; /* Limit height */
    object-fit: contain; /* Ensure image fits nicely */
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

    <div class="content-cards-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">
        
        <div class="content-card" style="flex: 2 1 400px;">
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

        <div class="content-card" style="flex: 1 1 300px;">
            <h3 class="section-title">Equipment Images</h3>
            
            <div class="main-img-container">
                @php 
                    $images = $request->maintenanceRequest->images;
                @endphp

                @if($images->isNotEmpty())
                    {{-- Scenario 1: Images Exist --}}
                    @php 
                        $mainImg = asset('storage/' . $images->first()->imagePath);
                    @endphp
                    <img src="{{ $mainImg }}" id="equipment-img" onclick="viewImage(this.src)" alt="Main Image">
                @else
                    {{-- Scenario 2: No Images --}}
                    <div style="text-align: center; color: #9ca3af; padding: 40px;">
                        <i class="fas fa-image" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                        <p style="font-weight: 500; font-size: 16px; margin: 0;">No attachment image</p>
                        <span style="font-size: 13px; opacity: 0.7;">The requester did not upload any photos.</span>
                    </div>
                @endif
            </div>
            
            {{-- Only show thumbnail section if there are images --}}
            @if($images->isNotEmpty())
                <span class="info-label" style="margin-top: 20px;">Additional Images</span>
                <div class="thumbnail-grid">
                    @foreach($images as $img)
                        <img src="{{ asset('storage/' . $img->imagePath) }}" class="thumbnail-img" onclick="viewImage(this.src)">
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>


<div id="imgModal" class="modal-overlay" onclick="closeImageModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-img" id="modalImage">
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

    // 2. Image Modal Functions
    function viewImage(src) {
        var modal = document.getElementById("imgModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "flex";
        modalImg.src = src;
    }

    function closeImageModal() {
        document.getElementById("imgModal").style.display = "none";
    }

    // Close Modals on Outside Click
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            // Close delete modals
            if(event.target.id && event.target.id.startsWith('deleteModal')) {
                event.target.classList.remove('show');
                event.target.classList.add('hidden');
            }
            // Close image modal
            if(event.target.id === 'imgModal') {
                event.target.style.display = "none";
            }
        }
    }
</script>
@endsection