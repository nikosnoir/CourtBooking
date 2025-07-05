<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION['user_name'];
$userRole = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - UiTM Court Booking</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      color: #333;
    }

    .navbar {
      background-color: #004080;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .container {
      max-width: 1000px;
      margin: 30px auto;
      text-align: center;
    }

    .welcome {
      font-size: 20px;
      margin-bottom: 30px;
    }

    .courts {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
      padding: 0 20px;
    }

    .court-card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: 0.3s ease;
      overflow: hidden;
    }

    .court-card:hover {
      transform: translateY(-4px);
    }

    .court-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .court-card h3 {
      padding: 15px;
      color: #004080;
    }

    .buttons {
      margin-top: 20px;
    }

    .buttons a {
      display: inline-block;
      margin: 10px;
      padding: 12px 20px;
      background-color: #005ea2;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }

    .buttons a:hover {
      background-color: #004b85;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

  <div class="container">
    <div class="welcome">
      Welcome, <strong><?= htmlspecialchars($userName) ?></strong>! You are logged in as <strong><?= htmlspecialchars($userRole) ?></strong>.
    </div>

    <div class="courts">
      <div class="court-card" onclick="window.location.href='booking.php?court=takraw'">
        <img src="https://i0.wp.com/www.ukuransaiz.com/wp-content/uploads/2025/02/Ukuran-Gelanggang-Sepak-Takraw-Rasmi-Sekolah-Rekreasi.webp" alt="Takraw Court">
        <h3>Takraw Court</h3>
      </div>
      <div class="court-card" onclick="window.location.href='booking.php?court=futsal'">
        <img src="https://cdn1.npcdn.net/userfiles/21669/image/01(3).jpg" alt="Futsal Court">
        <h3>Futsal Court</h3>
      </div>
      <div class="court-card" onclick="window.location.href='booking.php?court=volleyball'">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhoLjDRcc34BbV77mJhUJwGS0gw84aX_GLEnqmejyqsAZOGXChyphenhyphenlP5b7qX3LhyGgfVH8BsVIzmsq384Jr6FrdqE62B1hjUasHcmj3vbnbRW7mpdnYIZ676YR3_ULMcME0QfI9kvbStnmdI/s1600/Photo0015.jpg" alt="Volleyball Court">
        <h3>Volleyball Court</h3>
      </div>
    </div>

    <div class="buttons">
      <a href="my_bookings.php">📋 My Bookings</a>
      <?php if ($userRole === 'admin'): ?>
        <a href="admin_panel.php">🛠️ Admin Panel</a>
      <?php endif; ?>
      <a href="logout.php">🚪 Logout</a>
    </div>
  </div>

</body>
</html>
