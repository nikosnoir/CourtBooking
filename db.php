<?php
// Use environment variables for production, fallback to local for development
$host = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_HOST) : ($_ENV['DB_HOST'] ?? 'localhost');
$dbname = $_ENV['DATABASE_URL'] ? ltrim(parse_url($_ENV['DATABASE_URL'], PHP_URL_PATH), '/') : ($_ENV['DB_NAME'] ?? 'uitm_booking');
$username = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_USER) : ($_ENV['DB_USER'] ?? 'root');
$password = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PASS) : ($_ENV['DB_PASSWORD'] ?? '');
$port = $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PORT) : ($_ENV['DB_PORT'] ?? '3306');

try {
    // Add SSL support for PostgreSQL connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 10, // 10 second timeout
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}
?>
