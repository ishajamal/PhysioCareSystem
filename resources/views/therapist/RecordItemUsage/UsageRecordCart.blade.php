@extends('layouts.therapist')

@section('title', 'Usage Record')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

/* ================= PAGE WRAPPER ================= */
.page-wrapper {
    padding: 30px 50px 50px 50px;
    background: #f9fafb;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    color: #374151;
}

/* ================= HEADER ================= */
.page-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.header-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

/* ================= MODERN BUTTONS ================= */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    font-family: 'Segoe UI', sans-serif;
}

/* Cancel Button - Gray */
.btn-cancel {
    background-color: #f0f0f0;
    color: #333;
}

.btn-cancel:hover {
    background-color: #e0e0e0;
}

/* Submit Button - Green */
.btn-submit {
    background-color: #4caf50;
    color: white;
}

.btn-submit:hover {
    background-color: #43a047;
}

/* Add Item Button - Blue Gradient */
.btn-add {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-add:hover {
    background: linear-gradient(135deg, #1e40af, #1d4ed8);
}

/* Icon inside buttons */
.btn i {
    font-size: 18px;
}

/* ================= MAIN CARD ================= */
.usage-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

/* ================= TABLE ================= */
.usage-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.usage-table thead {
    background: #f3f4f6;
    border-bottom: 2px solid #e5e7eb;
}

.usage-table th, .usage-table td {
    padding: 18px 16px;
    text-align: left;
}

.usage-table th:first-child { width: 60px; text-align: center; }
.usage-table th:last-child { width: 130px; text-align: center; }

.no-center { text-align: center; color: #9ca3af; font-style: italic; }
.product-code { font-weight: 600; color: #111827; }
.product-name { color: #6b7280; }
.quantity-value { text-align: center; font-weight: 500; color: #111827; }

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

/* Edit / Delete Buttons inside table */
.btn-edit, .btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-edit { background-color: #fef3c7; color: #b45309; }
.btn-edit:hover { background-color: #fde68a; }

.btn-delete { background-color: #fee2e2; color: #b91c1c; }
.btn-delete:hover { background-color: #fca5a5; }

/* ================= RESPONSIVE ================= */
@media (max-width: 768px){
    .page-wrapper { padding: 20px; }
    .usage-card { padding: 25px; }
    .header-actions { flex-direction: column; gap: 10px; }
    .btn-add, .btn-submit, .btn-cancel { width: 100%; justify-content: center; }
}


</style>

<div >
    <!-- Header -->
    <div class="page-header">
        <!-- Cancel Button -->
        <button class="btn btn-cancel" onclick="openModal('cancelModal')">
            <i class="fas fa-arrow-left"></i> Cancel
        </button>

        <div class="header-actions">
            <!-- Add Item Button -->
            <button type="button" class="btn btn-add" onclick="window.location.href='{{ route('therapist.inventory.list') }}'">
                <i class="bi bi-plus-lg"></i> Add Item
            </button>

            <!-- Submit Button -->
            <button class="btn btn-submit" onclick="openModal('submitModal')">
                <i class="bi bi-floppy2-fill"></i> Submit
            </button>
        </div>
    </div>


    <!-- Main Card -->
    <div class="usage-card">
        <table class="usage-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cartItems as $index => $cart)
                    <tr>
                        <td class="no-center">{{ $index + 1 }}</td>
                        <td class="product-code">{{ $cart->itemID }}</td>
                        <td class="product-name">{{ $cart->itemMaintenanceInfo->itemName }}</td>
                        <td class="quantity-value">{{ $cart->quantityUsed }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" 
                                        onclick="window.location.href='{{ route('therapist.cart.edit', [$cart->itemID]) }}'">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete modal trigger -->
                                <button class="btn-delete" onclick="openModal('deleteModal{{ $cart->itemID }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Delete modal component -->
                    <x-delete-modal
                        id="deleteModal{{ $cart->itemID }}"
                        title="ARE YOU SURE YOU WANT TO DELETE THIS RECORD?"
                        message="This action cannot be undone."
                        route="{{ route('therapist.cart.delete', $cart->itemID) }}"
                        method="DELETE"
                    />
                    
                @empty
                    <tr>
                        <td colspan="5" class="no-center">No items added yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Cancel Modal -->
<x-modal
  id="cancelModal"
  title="Are you sure you want to cancel?"
  icon="fas fa-exclamation-circle"
  route="{{ route('therapist.cart.cancel') }}"
  method="POST"
  buttonText="Yes, Cancel"
  buttonIcon="fas fa-trash"
  :danger="true"
/>

<!-- Submit Modal -->
<x-modal
  id="submitModal"
  title="Are you sure you want to submit this usage record?"
  icon="fas fa-exclamation-triangle"
  route="{{ route('therapist.cart.submit') }}"
  buttonText="Submit"
  buttonIcon="fas fa-check-circle"
/>

@endsection
