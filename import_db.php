<?php
// Database import script for Render PostgreSQL
require_once 'db.php';

echo "<h1>Database Import Script</h1>";

// PostgreSQL schema for court booking system
$sql = "
-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20) NOT NULL CHECK (role IN ('student', 'staff', 'admin')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create courts table
CREATE TABLE IF NOT EXISTS courts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    location VARCHAR(255),
    type VARCHAR(20) CHECK (type IN ('takraw', 'futsal', 'volleyball')),
    status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive'))
);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    court_id INTEGER REFERENCES courts(id),
    booking_date DATE,
    booking_time TIME,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample courts data
INSERT INTO courts (name, location, type, status) VALUES
('Takraw Court A', 'UiTM Kampus Court 1', 'takraw', 'active'),
('Futsal Court B', 'UiTM Kampus Court 2', 'futsal', 'active'),
('Volleyball Court C', 'UiTM Kampus Court 3', 'volleyball', 'active')
ON CONFLICT DO NOTHING;

-- Insert sample users data
INSERT INTO users (name, email, password, role) VALUES
('ali', 'ali@student.uitm.edu.my', '\$2y\$10\$Q.araKNlKTVaOphZrecEguvCtQndNyc4/8qBdOZbwBdNP6Y6yYO5q', 'student'),
('iqmal', '2023837038@student.uitm.edu.my', '\$2y\$10\$VSThuwdskp7vf6Imh7g87Oh5SNEvH8T/vvVL8R52.WiXej9RCXwnO', 'admin')
ON CONFLICT (email) DO NOTHING;

-- Insert sample bookings data
INSERT INTO bookings (user_id, court_id, booking_date, booking_time, status, created_at) VALUES
(1, 3, '2025-07-07', '08:00:00', 'approved', '2025-07-05 19:23:36'),
(1, 1, '2025-07-07', '08:00:00', 'approved', '2025-07-05 19:24:32'),
(1, 1, '2025-07-06', '08:00:00', 'approved', '2025-07-05 21:00:03'),
(2, 1, '2025-07-16', '08:00:00', 'approved', '2025-07-05 22:40:34'),
(1, 1, '2025-07-08', '09:00:00', 'pending', '2025-07-05 22:47:05'),
(1, 3, '2025-07-07', '09:00:00', 'pending', '2025-07-05 23:32:01')
ON CONFLICT DO NOTHING;
";

try {
    echo "<p>Connecting to database...</p>";
    
    // Execute the schema
    $pdo->exec($sql);
    
    echo "<p style='color: green;'><strong>✅ Database schema imported successfully!</strong></p>";
    
    // Verify tables were created
    $result = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $result->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Tables created:</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Count records
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $courtCount = $pdo->query("SELECT COUNT(*) FROM courts")->fetchColumn();
    $bookingCount = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    
    echo "<h3>Data imported:</h3>";
    echo "<ul>";
    echo "<li>Users: $userCount</li>";
    echo "<li>Courts: $courtCount</li>";
    echo "<li>Bookings: $bookingCount</li>";
    echo "</ul>";
    
    echo "<p><strong>🎉 Your database is now ready!</strong></p>";
    echo "<p><a href='login.php'>Go to Login Page</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
}
?>
