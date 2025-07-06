<?php
// Use environment variables for production, fallback to local for development
$host = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_HOST) : ($_ENV['DB_HOST'] ?? 'localhost');
$dbname = $_ENV['DATABASE_URL'] ? ltrim(parse_url($_ENV['DATABASE_URL'], PHP_URL_PATH), '/') : ($_ENV['DB_NAME'] ?? 'uitm_booking');
$username = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_USER) : ($_ENV['DB_USER'] ?? 'root');
$password = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PASS) : ($_ENV['DB_PASSWORD'] ?? '');
$port = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PORT) : ($_ENV['DB_PORT'] ?? '3306');

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    // Enable exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}
?>
