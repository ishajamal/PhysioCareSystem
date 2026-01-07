<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | PhysioCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #6387c2;
      --primary-dark: #5070a8;
      --gray: #6c757d;
      --dark: #2c3e50;
      --success: #28a745;
      --danger: #dc3545;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e8f4fd, #d4e6f8);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .register-container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      display: flex;
      max-width: 1100px;
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .register-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .form-section {
      flex: 1.2;
      padding: 50px 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-section {
      flex: 0.8;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .logo-box img {
      max-width: 280px;
      filter: drop-shadow(0 0 8px rgba(0, 0, 0, 0.4));
    }

    .logo-box {
      padding: 16px;
    }

    h2 {
      font-size: 2rem;
      color: var(--dark);
      margin-bottom: 10px;
      font-weight: 700;
    }

    p.subtitle {
      color: var(--gray);
      margin-bottom: 30px;
      font-size: 0.95rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
      font-size: 0.9rem;
    }

    .form-group label .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .input-field,
    .password-wrapper {
      position: relative;
    }

    .input-field input,
    .password-wrapper input,
    .input-field select {
      width: 100%;
      padding: 14px 45px 14px 45px;
      border: 2px solid #e0e3e7;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      font-family: inherit;
    }

    .input-field select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 15px center;
      cursor: pointer;
    }

    .input-field input:focus,
    .password-wrapper input:focus,
    .input-field select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 135, 194, 0.2);
      outline: none;
    }

    .input-field i,
    .password-wrapper i.icon-left {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1rem;
      z-index: 1;
    }

    .password-wrapper .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      cursor: pointer;
      transition: color 0.3s;
      font-size: 1rem;
      z-index: 2;
      background: none;
      border: none;
      padding: 5px;
    }

    .password-wrapper .toggle-password:hover {
      color: var(--primary);
    }

    .register-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(to right, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(99, 135, 194, 0.3);
      margin-top: 10px;
    }

    .register-btn:hover {
      background: linear-gradient(to right, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(99, 135, 194, 0.4);
    }

    .register-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .error-message {
      color: var(--danger);
      font-size: 0.8rem;
      margin-top: 5px;
      display: block;
    }

    .error-alert {
      margin-bottom: 20px;
      padding: 12px;
      background: #f8d7da;
      color: #721c24;
      border-radius: 8px;
      border-left: 4px solid var(--danger);
      font-size: 0.9rem;
    }

    .login-link {
      text-align: center;
      margin-top: 25px;
      color: var(--gray);
      font-size: 0.95rem;
    }

    .login-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
      margin-left: 5px;
    }

    .login-link a:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }

    .logo-section h3 {
      margin-top: 20px;
      font-size: 1.5rem;
      text-align: center;
    }

    .logo-section p {
      text-align: center;
      opacity: 0.9;
      line-height: 1.5;
      font-size: 0.9rem;
      margin-top: 10px;
      max-width: 280px;
    }

    .logo-section ul {
      list-style: none;
      margin-top: 20px;
      text-align: left;
    }

    .logo-section ul li {
      padding: 8px 0;
      font-size: 0.85rem;
      opacity: 0.9;
    }

    .logo-section ul li i {
      margin-right: 10px;
      color: #fff;
    }

    @media (max-width: 768px) {
      .register-container {
        flex-direction: column;
      }

      .form-section {
        padding: 40px 30px;
      }

      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }

      .logo-section {
        padding: 30px;
      }

      .logo-box img {
        max-width: 200px;
      }
    }

    .loader {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid #f3f3f3;
      border-top: 2px solid var(--primary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .password-strength {
      height: 5px;
      background: #e0e3e7;
      border-radius: 3px;
      margin-top: 8px;
      overflow: hidden;
    }

    .password-strength-bar {
      height: 100%;
      width: 0%;
      transition: all 0.3s ease;
      border-radius: 3px;
    }

    .password-strength-bar.weak {
      width: 33%;
      background: var(--danger);
    }

    .password-strength-bar.medium {
      width: 66%;
      background: #ffc107;
    }

    .password-strength-bar.strong {
      width: 100%;
      background: var(--success);
    }

    .password-hint {
      font-size: 0.75rem;
      color: var(--gray);
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="form-section">
      <h2>Create Account</h2>
      <p class="subtitle">Join PhysioCare today</p>
      
      <form action="{{ route('register.post') }}" method="POST" id="registerForm">
        @csrf

        @if($errors->any())
          <div class="error-alert">
            @foreach($errors->all() as $error)
              {{ $error }}<br>
            @endforeach
          </div>
        @endif

        <div class="form-row">
          <div class="form-group">
            <label>Full Name<span class="required">*</span></label>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
            </div>
            @error('name')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Email Address<span class="required">*</span></label>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>
            @error('email')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Phone Number</label>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="tel" name="phoneNumber" value="{{ old('phoneNumber') }}" placeholder="012-3456789">
            </div>
            @error('phoneNumber')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Role<span class="required">*</span></label>
            <div class="input-field">
              <i class="fas fa-user-tag"></i>
              <select name="role" required>
                <option value="">Select Role</option>
                <option value="therapist" {{ old('role') == 'therapist' ? 'selected' : '' }}>Therapist</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              </select>
            </div>
            @error('role')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Password<span class="required">*</span></label>
            <div class="password-wrapper">
              <i class="fas fa-lock icon-left"></i>
              <input type="password" name="password" id="password" placeholder="Create password" required oninput="checkPasswordStrength()">
              <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="password-strength">
              <div class="password-strength-bar" id="strengthBar"></div>
            </div>
            <span class="password-hint">Minimum 8 characters</span>
            @error('password')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Confirm Password<span class="required">*</span></label>
            <div class="password-wrapper">
              <i class="fas fa-lock icon-left"></i>
              <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            @error('password_confirmation')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>
        
        <button type="submit" class="register-btn" id="registerBtn">
          <span id="btnText">Create Account</span>
          <span id="btnLoader" style="display: none;">
            <div class="loader"></div> Creating account...
          </span>
        </button>
        
        <div class="login-link">
          Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
      </form>
    </div>
    
    <div class="logo-section">
      <div class="logo-box">
        <img src="{{ asset('images/physiocare-logo.png') }}" alt="PhysioCare Logo" onerror="this.onerror=null; this.style.display='none';">
      </div>
      <p>Equipment & Supplies Management System</p>
      
    </div>
  </div>

  <script>
    function togglePassword(inputId, button) {
      const passwordInput = document.getElementById(inputId);
      const toggleIcon = button.querySelector('i');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }

    function checkPasswordStrength() {
      const password = document.getElementById('password').value;
      const strengthBar = document.getElementById('strengthBar');
      
      let strength = 0;
      if (password.length >= 8) strength++;
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
      if (password.match(/[0-9]/)) strength++;
      if (password.match(/[^a-zA-Z0-9]/)) strength++;
      
      strengthBar.className = 'password-strength-bar';
      
      if (strength <= 1) {
        strengthBar.classList.add('weak');
      } else if (strength <= 3) {
        strengthBar.classList.add('medium');
      } else {
        strengthBar.classList.add('strong');
      }
    }

    // Form submission handler
    document.getElementById('registerForm').addEventListener('submit', function() {
      const btn = document.getElementById('registerBtn');
      const btnText = document.getElementById('btnText');
      const btnLoader = document.getElementById('btnLoader');
      
      btn.disabled = true;
      btnText.style.display = 'none';
      btnLoader.style.display = 'inline';
    });

    // Auto focus on first input
    document.addEventListener('DOMContentLoaded', function() {
      const firstInput = document.querySelector('input[name="name"]');
      if (firstInput) firstInput.focus();
    });

    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>