<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - UiTM Court Booking</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background: url('https://img.freepik.com/premium-photo/8bit-pixel-art-football-stadium-background-2d-runner-background-ar-169-style-raw-job-id-7ad54a58ca1d49da8d1056efa5eb985d_939033-95216.jpg') no-repeat center center fixed;
      background-size: cover;
      background-color: #f4f6f8;
      color: #333;
    }

    .navbar {
      background-color: #004080;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .login-container {
      max-width: 400px;
      margin: 80px auto;
      padding: 2rem;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    .login-container h2 {
      color: #004080;
      margin-bottom: 1.5rem;
    }

    .login-input {
      width: 100%;
      padding: 12px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background-color: #004080;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-btn:hover {
      background-color: #003366;
    }

    .back-link {
      display: block;
      margin-top: 1.5rem;
      color: #004080;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .google-container {
      margin-top: 20px;
    }
  </style>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>

  <nav class="navbar">
    <h1>UiTM Court Booking</h1>
  </nav>

  <div class="login-container">
    <h2>Login with Email</h2>

    <form action="login_process.php" method="POST">
      <input type="email" name="email" placeholder="Email" class="login-input" required>
      <input type="password" name="password" placeholder="Password" class="login-input" required>
      <button type="submit" class="login-btn">Login</button>
    </form>

    <a href="register.php" style="display:block; margin-top: 1rem; background-color:#ccc; padding: 12px; border-radius: 6px; text-decoration: none; color: #004080; font-weight: bold;">
      Don’t have an account? Register here
    </a>


    <a class="back-link" href="index.php">← Back to Home</a>

    <div class="google-container">
      <div id="g_id_onload"
           data-client_id="44670180521-t081jd2g4kbst7cd2ac71di4flo1c4md.apps.googleusercontent.com"
           data-callback="handleGoogleLogin"
           data-auto_prompt="false">
      </div>

      <div class="g_id_signin"
           data-type="standard"
           data-size="medium"
           data-theme="outline"
           data-text="sign_in_with"
           data-shape="pill"
           data-logo_alignment="left">
      </div>
    </div>
  </div>

  <script>
    function handleGoogleLogin(response) {
      fetch('google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: response.credential })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          window.location.href = 'dashboard.php';
        } else {
          alert(data.message || 'Google login failed');
        }
      });
    }
  </script>

</body>
</html>
