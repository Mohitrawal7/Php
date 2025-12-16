<?php
require "../db.php";

if (!isset($_SESSION['user'])) exit;

$title = $_POST['title'];
$content = $_POST['content'];
$image = "";

if (!empty($_FILES['image']['name'])) {
    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
}

$stmt = $conn->prepare("INSERT INTO posts(title,content,image,user_id) VALUES (?,?,?,?)");
$stmt->bind_param("sssi", $title, $content, $image, $_SESSION['user']);
$stmt->execute();

echo json_encode(["success" => true]);
