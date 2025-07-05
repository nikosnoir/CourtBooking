<?php
session_start();
require 'db.php'; // make sure db.php sets up $pdo

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required.";
    header("Location: login.php");
    exit;
}

// Check if user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Save user info in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['error'] = "Invalid email or password.";
    header("Location: login.php");
    exit;
}
