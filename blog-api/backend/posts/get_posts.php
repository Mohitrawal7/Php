<?php
require "../db.php";
session_start(); // ✅ important to access $_SESSION

header("Content-Type: application/json");

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// Fetch posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = [];

while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);
