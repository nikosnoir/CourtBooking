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
<html>
<head>
    <title>Dashboard - UiTM Court Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f3f6fa;
        }
        .container {
            max-width: 800px;
            margin: 60px auto 0;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .info {
            font-size: 18px;
            margin: 20px 0;
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
    <h1>Welcome, <?= htmlspecialchars($userName); ?>!</h1>
    <p class="info">You are logged in as a <strong><?= htmlspecialchars($userRole); ?></strong>.</p>

    <div class="buttons">
        <a href="index.html">📅 Book a Court</a>
        <a href="my_bookings.php">📋 My Bookings</a>
        <?php if ($userRole === 'admin'): ?>
            <a href="admin_panel.php">🛠️ Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

</body>
</html>
