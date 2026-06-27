<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | PhysioCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --primary: #6387c2;
      --primary-dark: #5070a8;
      --gray: #6c757d;
      --dark: #2c3e50;
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

    .reset-container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      display: flex;
      max-width: 1000px;
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .reset-container::before {
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
    }

    .logo-box img {
      max-width: 350px;
      filter: drop-shadow(0 0 8px rgba(0, 0, 0, 0.4));
    }

    h2 {
      font-size: 2rem;
      color: var(--dark);
      margin-bottom: 10px;
      font-weight: 700;
    }

    .subtitle {
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

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      width: 100%;
      padding: 15px 45px;
      border: 2px solid #e0e3e7;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .password-wrapper input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 135, 194, 0.2);
      outline: none;
    }

    .password-wrapper i.fa-lock {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1.1rem;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      cursor: pointer;
      background: none;
      border: none;
      font-size: 1.1rem;
    }

    .toggle-password:hover {
      color: var(--primary);
    }

    .reset-btn {
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

    .reset-btn:hover {
      background: linear-gradient(to right, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(99, 135, 194, 0.4);
    }

    .error-alert {
      margin-bottom: 15px;
      padding: 12px;
      background: #f8d7da;
      color: #721c24;
      border-radius: 8px;
      text-align: center;
      border-left: 4px solid var(--danger);
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

    @media (max-width: 768px) {
      .reset-container {
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
  </style>
</head>

<body>
  <div class="reset-container">
    <div class="form-section">
      <h2>Reset Password</h2>
      <p class="subtitle">Create a new password for your PhysioCare account</p>

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

      <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
          <label>New Password</label>
          <div class="password-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Enter new password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label>Confirm New Password</label>
          <div class="password-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="reset-btn">
          Reset Password
        </button>

        <div class="login-link">
          Remember your password? <a href="{{ route('login') }}">Back to Login</a>
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
    function togglePassword(inputId, button) {
      const input = document.getElementById(inputId);
      const icon = button.querySelector('i');

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>