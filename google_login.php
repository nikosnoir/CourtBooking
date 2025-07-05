<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

// Load token from frontend
$input = json_decode(file_get_contents("php://input"), true);
$token = $input['token'] ?? '';

if (!$token) {
    echo json_encode(['status' => 'error', 'message' => 'No token received']);
    exit;
}

// Verify token with Google API
$payload = json_decode(file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=" . $token), true);

if (!isset($payload['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Google token']);
    exit;
}

$name = $payload['name'];
$email = $payload['email'];

// Check if user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// If not, auto-register
if (!$user) {
    $role = (str_contains($email, '@uitm.edu.my')) ? 'student' : 'staff';
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, '', ?)");
    $stmt->execute([$name, $email, $role]);

    $userId = $pdo->lastInsertId();
} else {
    $userId = $user['id'];
    $role = $user['role'];
    $name = $user['name'];
}

// Store in session
$_SESSION['user_id'] = $userId;
$_SESSION['user_name'] = $name;
$_SESSION['role'] = $role;

echo json_encode(['status' => 'success']);
