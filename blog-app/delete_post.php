<?php
require 'db.php';

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get post to delete image
$sql = $conn->prepare("SELECT image FROM posts WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$post = $result->fetch_assoc();

// Delete image file if exists
if($post && $post['image'] && file_exists("uploads/".$post['image'])){
    unlink("uploads/".$post['image']);
}

// Delete from database
$del = $conn->prepare("DELETE FROM posts WHERE id=?");
$del->bind_param("i", $id);
$del->execute();

header("Location: index.php");
exit();
