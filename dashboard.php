<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user data from session
$userName = $_SESSION['user_name'];
$userRole = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - UiTM Court Booking</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f3f6fa; }
        .container { max-width: 800px; margin: auto; text-align: center; }
        h1 { color: #333; }
        .info { font-size: 18px; margin: 20px 0; }
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

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
    <p class="info">You are logged in as a <strong><?php echo htmlspecialchars($userRole); ?></strong>.</p>

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
