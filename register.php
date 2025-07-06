<?php
require 'db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkStmt->execute([$email]);

    if ($checkStmt->rowCount() > 0) {
        $message = "⚠️ Email already registered!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
        $message = "✅ Registration successful! <a href='login.php'>Login here</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - UiTM Court Booking</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
        }

        /* Simple Navbar */
        .navbar {
            background-color: #004080;
            color: white;
            padding: 16px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .register-container {
            max-width: 450px;
            margin: 60px auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.4rem;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #004080;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #003060;
        }

        .msg {
            text-align: center;
            margin-top: 1rem;
            color: #004080;
        }

        .msg a {
            color: #004080;
            font-weight: bold;
            text-decoration: none;
        }

        .msg a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #004080;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="navbar">
    UiTM Court Booking - Register
</div>

<div class="register-container">
    <h2>Register</h2>

    <form method="POST">
        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="role">Register As</label>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="staff">Staff</option>
        </select>

        <button type="submit">Register</button>

        <div class="msg"><?php echo $message; ?></div>
    </form>

    <a class="back-link" href="login.php">← Already have an account? Login here</a>
</div>

</body>
</html>
