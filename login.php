<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - UiTM Court Booking</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Internal CSS Styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h2 {
            color: #004080;
            margin-bottom: 1.5rem;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container button:hover {
            background-color: #003366;
        }

        .login-container .back-link {
            display: block;
            margin-top: 1rem;
            color: #004080;
            text-decoration: none;
        }

        .login-container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login with Email</h2>
        <form method="POST" action="login_process.php">
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <a class="back-link" href="index.html">← Back to Home</a>
        <?php if (isset($_SESSION['error'])): ?>
    <p style="color: red; margin-bottom: 1rem;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    </div>

</body>
</html>
