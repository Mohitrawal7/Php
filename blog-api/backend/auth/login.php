<?php
require "../db.php";
session_start();

// Get input JSON safely
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['email'], $data['password'])) {
    echo json_encode(["error" => "Email or password missing"]);
    exit;
}

$email = $data['email'];
$pass  = $data['password'];

// Fetch user from DB
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

// Verify password
if ($res && password_verify($pass, $res['password'])) {
    $_SESSION['user'] = $res['id'];
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Invalid login"]);
}
