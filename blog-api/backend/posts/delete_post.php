<?php
require "../db.php";

if (!isset($_SESSION['user'])) exit;

$id = $_POST['id'];
$conn->query("DELETE FROM posts WHERE id=$id");

echo json_encode(["success" => true]);
