<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

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
    <link rel="stylesheet" href="style.css">
    <style>
        .booking-container {
            max-width: 1000px;
            margin: 80px auto;
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .booking-container h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 30px;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        .bookings-table th {
            background-color: #004080;
            color: white;
            padding: 14px;
            font-size: 16px;
        }

        .bookings-table td {
            padding: 12px;
            text-align: center;
            font-size: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .no-booking {
            text-align: center;
            color: #666;
            font-size: 17px;
            padding: 30px 0;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #004080;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="booking-container">
    <h2><?php echo htmlspecialchars($userName); ?>'s Court Bookings</h2>

    <?php if (count($bookings) > 0): ?>
        <table class="bookings-table">
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
        <p class="no-booking">You have no bookings yet.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
