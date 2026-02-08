<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | PhysioCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    :root {
      --primary: #6387c2;
      --primary-dark: #5070a8;
      --gray: #6c757d;
      --dark: #2c3e50;
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

    .login-container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      display: flex;
      max-width: 1000px;
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .form-section {
      flex: 1;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-section {
      flex: 1;
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
      max-width: 350px;
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

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
    }

    .input-field,
    .password-wrapper {
      position: relative;
    }

    .input-field input,
    .password-wrapper input {
      width: 100%;
      padding: 15px 45px 15px 45px;
      border: 2px solid #e0e3e7;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .input-field input:focus,
    .password-wrapper input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 135, 194, 0.2);
      outline: none;
    }

    .input-field i,
    .password-wrapper i.fa-lock {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1.1rem;
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
      font-size: 1.1rem;
      z-index: 2;
      background: none;
      border: none;
      padding: 5px;
    }

    .password-wrapper .toggle-password:hover {
      color: var(--primary);
    }

    .login-btn {
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

    .login-btn:hover {
      background: linear-gradient(to right, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(99, 135, 194, 0.4);
    }

    .login-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .error-message {
      color: #e74c3c;
      font-size: 0.875rem;
      margin-top: 5px;
      display: block;
    }

    .success-message {
      margin-bottom: 15px;
      padding: 12px;
      background: #d4edda;
      color: #155724;
      border-radius: 8px;
      text-align: center;
      border-left: 4px solid #28a745;
    }

    .error-alert {
      margin-bottom: 15px;
      padding: 12px;
      background: #f8d7da;
      color: #721c24;
      border-radius: 8px;
      text-align: center;
      border-left: 4px solid #dc3545;
    }

    .register-link {
      text-align: center;
      margin-top: 25px;
      color: var(--gray);
      font-size: 0.95rem;
    }

    .register-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
      margin-left: 5px;
    }

    .register-link a:hover {
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

    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
      }

      .form-section {
        padding: 40px 30px;
      }

      .logo-section {
        padding: 30px;
      }

      .logo-box img {
        max-width: 200px;
      }
    }

    /* Loading animation */
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
  </style>
</head>
<body>
  <div class="login-container">
    <div class="form-section">
      <h2>Welcome Back</h2>
      <p class="subtitle">Please login to your account</p>
      
      <form action="{{ route('login.post') }}" method="POST" id="loginForm">
        @csrf

        @if(session('success'))
          <div class="success-message">{{ session('success') }}</div>
        @endif

        @if(session('error'))
          <div class="error-alert">{{ session('error') }}</div>
        @endif

        @if($errors->any())
          <div class="error-alert">
            @foreach($errors->all() as $error)
              {{ $error }}<br>
            @endforeach
          </div>
        @endif

        <div class="form-group">
          <label>ID</label>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="id" value="{{ old('id') }}" placeholder="Enter your ID" required>
          </div>
        </div>
        
        <div class="form-group">
          <label>Password</label>
          <div class="password-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <button type="button" class="toggle-password" onclick="togglePassword()">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        
        <button type="submit" class="login-btn" id="loginBtn">
          <span id="btnText">Login</span>
          <span id="btnLoader" style="display: none;">
            <div class="loader"></div> Logging in...
          </span>
        </button>
        
        <div class="register-link">
          Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
      </form>
    </div>
    
    <div class="logo-section">
      <div class="logo-box">
        <img src="{{ asset('images/physiocare-logo.png') }}" alt="PhysioCare Logo" onerror="this.onerror=null; this.style.display='none';">
      </div>
      <h3>PhysioCare Professional</h3>
      <p>Advanced therapy management system</p>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.querySelector('.toggle-password i');
      
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

    // Form submission handler
    document.getElementById('loginForm').addEventListener('submit', function() {
      const btn = document.getElementById('loginBtn');
      const btnText = document.getElementById('btnText');
      const btnLoader = document.getElementById('btnLoader');
      
      btn.disabled = true;
      btnText.style.display = 'none';
      btnLoader.style.display = 'inline';
    });

    // Auto focus on first input
    document.addEventListener('DOMContentLoaded', function() {
      const firstInput = document.querySelector('input[name="id"]');
      if (firstInput) firstInput.focus();
    });

    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>