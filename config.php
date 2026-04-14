<?php
// ---------------------
// CamJobConnect Config
// ---------------------

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = ""; // Adjust if you have a MySQL password
$DB_NAME = "camjobconnect";

// Connect to MySQL
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $DB_NAME");
$conn->select_db($DB_NAME);

// Tables creation
// Users table
$conn->query("CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','provider','client') NOT NULL,
    profile_pic VARCHAR(255),
    mtn_number VARCHAR(20),
    orange_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Services table
$conn->query("CREATE TABLE IF NOT EXISTS services(
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id INT NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(provider_id) REFERENCES users(id) ON DELETE CASCADE
)");

// Jobs table
$conn->query("CREATE TABLE IF NOT EXISTS jobs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    provider_id INT NOT NULL,
    service_id INT NOT NULL,
    payment_method ENUM('mtn','orange') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(provider_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
)");

// Payments table (to track commissions)
$conn->query("CREATE TABLE IF NOT EXISTS payments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    admin_commission DECIMAL(10,2) NOT NULL,
    payment_method ENUM('mtn','orange') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(job_id) REFERENCES jobs(id) ON DELETE CASCADE
)");

// Reviews table
$conn->query("CREATE TABLE IF NOT EXISTS reviews(
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    provider_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(provider_id) REFERENCES users(id) ON DELETE CASCADE
)");

// Default admin account
$admin_email = "camjobconnect@gmail.com.com";
$admin_pass = password_hash("admin123", PASSWORD_DEFAULT);
$check_admin = $conn->query("SELECT * FROM users WHERE email='$admin_email'");
if($check_admin->num_rows == 0){
    $conn->query("INSERT INTO users(fullname,email,password,role) VALUES('Admin','$admin_email','$admin_pass','admin')");
}
?>
