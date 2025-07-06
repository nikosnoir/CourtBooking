<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UiTM Court Booking</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_64tjkpnPf7uRc4Xx0w4LrH3Vv5O562Ctg2ueDI44xzidkM2KVUCL5Vq-l7VCjlFA0kJWp6gIJrpCVgf4teLq8HUgeON_8E8PLqd63-HtENlfIo0hjTSqOXvBTARwKMszAktgFhyphenhyphenb5OaH/s1600/Photo1142.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    .hero {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 90vh;
      text-align: center;
      padding: 20px;
    }

    .hero img {
      width: 120px;
      margin-bottom: 20px;
    }

    .hero h1 {
      font-size: 40px;
      margin-bottom: 15px;
      color: #ffffff;
    }

    .hero p {
      font-size: 18px;
      max-width: 600px;
      margin: 0 auto 30px;
      color: #f1f1f1;
    }

    .cta-btn {
      background-color: #0073e6;
      padding: 12px 25px;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .cta-btn:hover {
      background-color: #005bb5;
    }

    .content-wrapper {
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="content-wrapper">
    <div class="hero">
      <img src="https://brandlogos.net/wp-content/uploads/2013/06/uitm-vector-logo.png" alt="UiTM Logo">
      <h1>Welcome to UiTM Court Booking</h1>
      <p>Book your favorite courts for takraw, futsal, or volleyball with just a few clicks. Fast, simple, and made for UiTM students and staff.</p>
      <a href="login.php" class="cta-btn">Get Started</a>
    </div>
  </div>
</body>
</html>
