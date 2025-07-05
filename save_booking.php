<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// Only allow POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$court = $data['court'] ?? '';
$date = $data['date'] ?? '';
$time = $data['time'] ?? null;
$userId = $_SESSION['user_id'];

// Validate
if (empty($court) || empty($date) || $time === null) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

// Get court ID from courts table
$stmt = $pdo->prepare("SELECT id FROM courts WHERE type = ? AND status = 'active'");
$stmt->execute([$court]);
$courtData = $stmt->fetch();

if (!$courtData) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid court']);
    exit;
}

$courtId = $courtData['id'];

// Check for conflict
$conflictCheck = $pdo->prepare("SELECT * FROM bookings WHERE court_id = ? AND booking_date = ? AND booking_time = ?");
$conflictCheck->execute([$courtId, $date, sprintf('%02d:00:00', $time)]);

if ($conflictCheck->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Time slot already booked']);
    exit;
}

// Save booking
$insert = $pdo->prepare("INSERT INTO bookings (user_id, court_id, booking_date, booking_time, status) VALUES (?, ?, ?, ?, 'pending')");
$insert->execute([$userId, $courtId, $date, sprintf('%02d:00:00', $time)]);

echo json_encode(['status' => 'success', 'message' => 'Booking saved!']);
