<?php
// ===== CORS HEADERS =====
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ===== DATABASE =====
$host = "localhost";
$user = "root";
$pass = "";
$db   = "blog_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed");
}

// session_start();

// /* AUTO CREATE TABLES */
// $conn->query("CREATE TABLE IF NOT EXISTS users (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(100),
//     email VARCHAR(255) UNIQUE,
//     password VARCHAR(255),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )");

// $conn->query("CREATE TABLE IF NOT EXISTS posts (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(255),
//     content TEXT,
//     image VARCHAR(255),
//     user_id INT,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )");
// ?>
