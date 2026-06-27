@extends('layouts.app')

@section('title', 'Manage Account')

@section('content')
<style>
.profile-container {
    max-width: 980px;
    margin: 0 auto;
}

.profile-hero {
    background: linear-gradient(135deg, #6387c2, #26599F);
    border-radius: 24px;
    padding: 32px;
    color: white;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 22px;
    box-shadow: 0 14px 35px rgba(38, 89, 159, 0.25);
}

.avatar-box {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255,255,255,0.45);
}

.avatar-box i {
    font-size: 46px;
}

.hero-title {
    font-size: 30px;
    font-weight: 800;
    margin: 0;
}

.hero-subtitle {
    margin: 6px 0 0;
    opacity: 0.9;
}

.profile-card {
    background: rgba(255,255,255,0.95);
    border-radius: 24px;
    padding: 34px;
    box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    border: 1px solid #eef2ff;
}

.section-label {
    font-size: 16px;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-label i {
    color: #26599F;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.form-group {
    margin-bottom: 22px;
}

.form-group.full {
    grid-column: 1 / -1;
}

.form-group label {
    display: block;
    font-size: 12px;
    font-weight: 800;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 8px;
}

.input-wrap {
    position: relative;
}

.input-wrap i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.form-control {
    width: 100%;
    padding: 14px 15px 14px 44px;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #f9fafb;
    font-size: 14px;
    outline: none;
    transition: .25s;
}

.form-control:focus {
    border-color: #6387c2;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(99,135,194,.14);
}

.form-control[readonly] {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
}

.note-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 7px;
}

.divider {
    border: none;
    height: 1px;
    background: #e5e7eb;
    margin: 10px 0 26px;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 12px;
}

.btn-back,
.btn-save {
    border: none;
    padding: 13px 22px;
    border-radius: 14px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
    transition: .25s;
}

.btn-back {
    background: #f3f4f6;
    color: #111827;
}

.btn-back:hover {
    background: #e5e7eb;
    color: #111827;
}

.btn-save {
    background: linear-gradient(135deg, #6387c2, #26599F);
    color: white;
    box-shadow: 0 8px 18px rgba(38,89,159,.25);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(38,89,159,.32);
}

@media (max-width: 768px) {
    .profile-hero {
        flex-direction: column;
        text-align: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .actions {
        flex-direction: column;
    }

    .btn-back,
    .btn-save {
        width: 100%;
        text-align: center;
    }
}
</style>

<div class="profile-container">

    <div class="profile-hero">
        <div class="avatar-box">
            <i class="far fa-user-circle"></i>
        </div>
        <div>
            <h1 class="hero-title">Manage Account</h1>
            <p class="hero-subtitle">Update your profile information and account password.</p>
        </div>
    </div>

    <div class="profile-card">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="section-label">
                <i class="fas fa-id-card"></i>
                Account Information
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>User ID</label>
                    <div class="input-wrap">
                        <i class="fas fa-id-badge"></i>
                        <input type="text" class="form-control" value="{{ $user->userID }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <div class="input-wrap">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="note-text">This email is used for password reset and notifications.</div>
                </div>

                <div class="form-group full">
                    <label>Phone Number</label>
                    <div class="input-wrap">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phoneNumber" class="form-control"
                               value="{{ old('phoneNumber', $user->phoneNumber) }}"
                               placeholder="012-3456789">
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="section-label">
                <i class="fas fa-lock"></i>
                Change Password
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>New Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password" class="form-control"
                               placeholder="Leave blank if unchanged">
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="javascript:history.back()" class="btn-back">Back</a>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection