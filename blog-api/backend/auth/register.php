<?php
require "../db.php";


$data = json_decode(file_get_contents("php://input"), true);

$name  = $data['name'];
$email = $data['email'];
$pass  = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)");
$stmt->bind_param("sss", $name, $email, $pass);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Email already exists"]);
}
