<?php
require "../db.php";

if (!isset($_SESSION['user'])) exit;

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

$stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
$stmt->bind_param("ssi", $title, $content, $id);
$stmt->execute();

echo json_encode(["success" => true]);
