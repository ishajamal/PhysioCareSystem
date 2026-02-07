@extends('layouts.app')

@section('title', 'Edit User')

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

.user-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.user-subtitle {
    font-size: 16px;
    color: #6b7280;
    margin-top: 8px;
    font-weight: 500;
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

.btn-secondary:hover {
    background-color: #e5e5e5;
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
.user-detail-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
}

@media (max-width: 900px) {
    .user-detail-wrapper {
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
    margin-bottom: 25px;
    font-size: 1.25rem;
    color: #1f2937;
    padding-bottom: 10px;
    border-bottom: 2px solid #f3f4f6;
}

/* ================= INFO ITEMS ================= */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 25px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 12px;
    text-transform: uppercase;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    letter-spacing: 0.5px;
}

/* ================= FORM CONTROLS ================= */
.form-control-lg {
    padding: 14px 16px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    background-color: white;
    font-size: 14px;
    color: #1f2937;
    width: 100%;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-control-lg::placeholder {
    color: #9ca3af;
}

/* ================= ROLE SELECT ================= */
.role-select {
    width: 100%;
    padding: 14px 16px;
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

.role-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* ================= ROLE BADGE ================= */
.role-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #dbeafe;
    color: #1e40af;
}

/* ================= USER INFO HEADER ================= */
.user-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e5e7eb;
}

.user-header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.user-email {
    font-size: 16px;
    color: #6b7280;
    margin-bottom: 15px;
    font-weight: 500;
}
</style>

<div class="main-content-view">
    <form method="POST" action="{{ route('admin.manage.user.update', $user->userID) }}">
        @csrf

                        <div class="row g-5"> {{-- g-5 = big vertical spacing --}}

                            {{-- FULL NAME --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Full Name</label>
                                <input type="text"
                                       name="name"
                                       value="{{ $user->name }}"
                                       class="form-control form-control-lg py-3">
                            </div>
                            <br>
                            {{-- EMAIL --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Email Address</label>
                                <input type="email"
                                       name="email"
                                       value="{{ $user->email }}"
                                       class="form-control form-control-lg py-3">
                            </div>
                            <br>
                            {{-- ROLE --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">Role</label>
                                <select name="role" class="form-control form-control-lg py-3">
                                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                    <option value="therapist" {{ $user->role=='therapist'?'selected':'' }}>Therapist</option>
                                    <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                                    <option value="technician" {{ $user->role=='technician'?'selected':'' }}>Technician</option>
                                    <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                                </select>
                            </div>
                            <br>
                            {{-- PASSWORD --}}
                            <div class="col-12">
                                <label class="font-weight-bold mb-2">
                                    Password <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg py-3"
                                       placeholder="Leave blank if no change">
                            </div>

                        </div>
                            <br>
                        <hr class="my-5">
                            <br>
                        {{-- BUTTONS --}}
                         <button class="btn btn-primary btn-lg">
                        Save Changes
                    </button>
                

                        <div class="text-center mt-4">
                    <a href="{{ route('admin.manage.user') }}" 
                    class="btn btn-secondary btn-lg mr-3">
                    Back
                    </a>
                </div>    
                   

                    </form>

                </div>
            </div>

        </div>
    </form>
</div>

<script>
    // Add form validation feedback
    document.querySelector('form').addEventListener('submit', function(e) {
        const nameInput = document.querySelector('input[name="name"]');
        const emailInput = document.querySelector('input[name="email"]');
        let isValid = true;

        // Reset styles
        [nameInput, emailInput].forEach(input => {
            input.style.borderColor = '#d1d5db';
        });

        // Validate name
        if (!nameInput.value.trim()) {
            nameInput.style.borderColor = '#ef4444';
            isValid = false;
        }

        // Validate email
        if (!emailInput.value.trim() || !emailInput.checkValidity()) {
            emailInput.style.borderColor = '#ef4444';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
        }
    });
</script>
@endsection