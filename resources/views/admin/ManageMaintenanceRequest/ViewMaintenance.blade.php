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
}

.btn-secondary {
    background-color: #f0f0f0;
    color: #333;
}

.btn-danger {
    background-color: #fee2e2;
    color: #b91c1c;
}

/* ================= CONTENT CARD ================= */
.content-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

/* ================= INFO GRID ================= */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
    padding: 16px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
    color: #374151;
}

/* ================= STATUS STYLES ================= */
.status-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-pending { background-color: #f59e0b; }
.status-in-progress { background-color: #3b82f6; }
.status-completed { background-color: #10b981; }

/* ================= IMAGE SECTION ================= */
.main-img img {
    width: 100%;
    max-height: 400px;
    object-fit: contain;
    border-radius: 16px;
    cursor: pointer;
}

.thumbnail-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid #e5e7eb;
}

/* ================= IMAGE MODAL ================= */
#imgModal {
    display: none;
    position: fixed;
    z-index: 9998;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    align-items: center;
    justify-content: center;
}

#imgModal.show {
    display: flex !important;
}
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

    <div class="content-card">
        <h3 style="font-weight: 700; margin-bottom: 20px;">Equipment Maintenance Details</h3>
        
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
            <div class="info-box" style="min-height: 100px;">{{ $request->detailsMaintenance ?? 'No additional details.' }}</div>
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

        <h3 style="font-weight: 700; margin-bottom: 20px;">Submitted By</h3>
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

    <div class="content-card">
        <h3 style="font-weight: 700; margin-bottom: 20px;">Equipment Images</h3>
        <div class="main-img">
            @php 
                $images = $request->maintenanceRequest->images;
                $mainImg = $images->first() ? asset('storage/' . $images->first()->imagePath) : asset('images/placeholder.jpg');
            @endphp
            <img src="{{ $mainImg }}" id="equipment-img" onclick="viewImage(this.src)" alt="Main Image">
        </div>
        
        <span class="info-label" style="margin-top: 20px;">Additional Images</span>
        <div class="thumbnail" style="display: flex; gap: 10px; margin-top: 10px;">
            @forelse($images as $img)
                <img src="{{ asset('storage/' . $img->imagePath) }}" class="thumbnail-img" onclick="viewImage(this.src)">
            @empty
                <span style="color: #9ca3af; font-style: italic;">No additional images uploaded</span>
            @endforelse
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