<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$userName = $_SESSION['user_name'] ?? 'Guest';
$userRole = $_SESSION['role'] ?? '';
?>
<style>
.navbar {
    background-color: #004080;
    padding: 1rem 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.navbar .nav-left {
    font-size: 1.4rem;
    font-weight: bold;
}
.navbar .nav-right a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 500;
    transition: color 0.2s;
}
.navbar .nav-right a:hover {
    color: #b3d9ff;
}
</style>

<div class="navbar">
    <div class="nav-left">UiTM Court Booking</div>
    <div class="nav-right">
        <a href="index.html">Home</a>
        <a href="my_bookings.php">My Bookings</a>
        <?php if ($userRole === 'admin'): ?>
            <a href="admin_panel.php">Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </div>
</div>
