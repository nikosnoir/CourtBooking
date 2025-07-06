<?php
session_start();
require 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle approval or rejection
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'], $_POST['booking_id'])) {
    $bookingId = $_POST['booking_id'];
    $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$action, $bookingId]);
    header("Location: admin_panel.php");
    exit;
}

// Fetch all bookings
$stmt = $pdo->query("
    SELECT b.id, u.name AS user_name, u.role, c.name AS court_name, c.type, b.booking_date, b.booking_time, b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN courts c ON b.court_id = c.id
    ORDER BY b.booking_date DESC, b.booking_time DESC
");
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - UiTM Court Booking</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #333;
        }

        .navbar {
            background-color: #004080;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 14px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #003366;
            color: white;
        }

        .actions form {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .approve, .reject {
            padding: 6px 12px;
            font-size: 13px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve {
            background-color: #28a745;
            color: white;
        }

        .reject {
            background-color: #dc3545;
            color: white;
        }

        .approve:hover {
            background-color: #218838;
        }

        .reject:hover {
            background-color: #c82333;
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

        .back {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #004080;
            text-decoration: none;
            font-weight: bold;
        }

        .back:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            table {
                font-size: 12px;
            }

            .approve, .reject {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h2>Admin Panel: Manage Bookings</h2>

    <?php if (count($bookings) > 0): ?>
        <table>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Court</th>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['user_name']) ?></td>
                    <td><?= ucfirst($b['role']) ?></td>
                    <td><?= htmlspecialchars($b['court_name']) ?></td>
                    <td><?= ucfirst($b['type']) ?></td>
                    <td><?= htmlspecialchars($b['booking_date']) ?></td>
                    <td><?= substr($b['booking_time'], 0, 5) ?></td>
                    <td class="status-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></td>
                    <td class="actions">
                        <?php if ($b['status'] === 'pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                                <button class="approve" name="action" value="approve">Approve</button>
                                <button class="reject" name="action" value="reject">Reject</button>
                            </form>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No bookings found.</p>
    <?php endif; ?>

    <a class="back" href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
