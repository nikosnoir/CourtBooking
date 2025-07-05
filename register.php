<?php
require 'db.php'; // include DB connection

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    // Check if email already exists
    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkStmt->execute([$email]);

    if ($checkStmt->rowCount() > 0) {
        $message = "⚠️ Email already registered!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
        $message = "✅ Registration successful! <a href='index.php'>Login here</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - UiTM Court Booking</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #eef3f7; }
        form { background: white; padding: 20px; max-width: 400px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; }
        button { padding: 10px; background-color: #005ea2; color: white; border: none; width: 100%; border-radius: 4px; }
        .msg { margin-top: 10px; color: red; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Register as UiTM Staff / Student</h2>

<form method="POST" action="">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role" required>
        <option value="student">Student</option>
        <option value="staff">Staff</option>
    </select>

    <button type="submit">Register</button>

    <div class="msg"><?php echo $message; ?></div>
</form>

</body>
</html>
