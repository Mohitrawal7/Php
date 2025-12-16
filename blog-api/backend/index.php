<?php
require "db.php";
session_start(); // ✅ start the session

header("Content-Type: application/json");


// Check if session exists
if (isset($_SESSION['user'])) {
    echo json_encode(["session_active" => true, "user_id" => $_SESSION['user']]);
} else {
    echo json_encode(["session_active" => false]);
}
?>