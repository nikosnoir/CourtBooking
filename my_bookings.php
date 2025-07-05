<?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Get user's bookings
$stmt = $pdo->prepare("
    SELECT b.booking_date, b.booking_time, b.status, c.name AS court_name, c.type 
    FROM bookings b
    JOIN courts c ON b.court_id = c.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC, b.booking_time DESC
");
$stmt->execute([$userId]);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings - UiTM Court Booking</title>
    <style>
        body { font-family: Arial; background: #f0f4f9; padding: 40px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #005ea2; color: white; }
        .status-pending { color: orange; }
        .status-approved { color: green; }
        .status-rejected { color: red; }
        a.back { display: block; margin-top: 20px; text-align: center; text-decoration: none; color: #005ea2; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2><?php echo htmlspecialchars($userName); ?>'s Bookings</h2>

    <?php if (count($bookings) > 0): ?>
        <table>
            <tr>
                <th>Court</th>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['court_name']) ?></td>
                    <td><?= ucfirst($b['type']) ?></td>
                    <td><?= htmlspecialchars($b['booking_date']) ?></td>
                    <td><?= substr($b['booking_time'], 0, 5) ?></td>
                    <td class="status-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">You have no bookings yet.</p>
    <?php endif; ?>

    <a class="back" href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
