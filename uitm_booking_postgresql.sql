-- PostgreSQL version of the UiTM Booking database schema
-- Converted from MySQL to PostgreSQL

-- Drop tables if they exist (for clean import)
DROP TABLE IF EXISTS bookings CASCADE;
DROP TABLE IF EXISTS courts CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- Create users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20) NOT NULL CHECK (role IN ('student', 'staff', 'admin')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create courts table
CREATE TABLE courts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    location VARCHAR(255),
    type VARCHAR(20) CHECK (type IN ('takraw', 'futsal', 'volleyball')),
    status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive'))
);

-- Create bookings table
CREATE TABLE bookings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    court_id INTEGER REFERENCES courts(id),
    booking_date DATE,
    booking_time TIME,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample users
INSERT INTO users (name, email, password, role) VALUES
('ali', 'ali@student.uitm.edu.my', '$2y$10$Q.araKNlKTVaOphZrecEguvCtQndNyc4/8qBdOZbwBdNP6Y6yYO5q', 'student'),
('iqmal', '2023837038@student.uitm.edu.my', '$2y$10$VSThuwdskp7vf6Imh7g87Oh5SNEvH8T/vvVL8R52.WiXej9RCXwnO', 'admin');

-- Insert sample courts
INSERT INTO courts (name, location, type, status) VALUES
('Takraw Court A', 'UiTM Kampus Court 1', 'takraw', 'active'),
('Futsal Court B', 'UiTM Kampus Court 2', 'futsal', 'active'),
('Volleyball Court C', 'UiTM Kampus Court 3', 'volleyball', 'active');

-- Insert sample bookings
INSERT INTO bookings (user_id, court_id, booking_date, booking_time, status, created_at) VALUES
(1, 3, '2025-07-07', '08:00:00', 'approved', '2025-07-05 19:23:36'),
(1, 1, '2025-07-07', '08:00:00', 'approved', '2025-07-05 19:24:32'),
(1, 1, '2025-07-06', '08:00:00', 'approved', '2025-07-05 21:00:03'),
(2, 1, '2025-07-16', '08:00:00', 'approved', '2025-07-05 22:40:34'),
(1, 1, '2025-07-08', '09:00:00', 'pending', '2025-07-05 22:47:05'),
(1, 3, '2025-07-07', '09:00:00', 'pending', '2025-07-05 23:32:01');

-- Create indexes for better performance
CREATE INDEX idx_bookings_user_id ON bookings(user_id);
CREATE INDEX idx_bookings_court_id ON bookings(court_id);
CREATE INDEX idx_bookings_date ON bookings(booking_date);
