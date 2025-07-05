<?php
require 'db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "❌ Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - UiTM Court Booking</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #eef3f7; }
        form { background: white; padding: 20px; max-width: 400px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        input { width: 100%; padding: 10px; margin: 8px 0; }
        button { padding: 10px; background-color: #005ea2; color: white; border: none; width: 100%; border-radius: 4px; }
        .msg { margin-top: 10px; color: red; text-align: center; }
        .link { text-align: center; margin-top: 15px; display: block; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Login to UiTM Court Booking</h2>

<form method="POST" action="">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>

    <div class="msg"><?php echo $message; ?></div>
    <a class="link" href="register.php">Don't have an account? Register here</a>
</form>

</body>
</html>
