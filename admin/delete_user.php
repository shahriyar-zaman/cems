<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

$user_id = $_GET['id'];

$sql_delete = "DELETE FROM users WHERE UserID = $user_id";
if (mysqli_query($link, $sql_delete)) {
    header("location: manage_users.php");
} else {
    echo "ERROR: Could not execute $sql_delete. " . mysqli_error($link);
}
?>
