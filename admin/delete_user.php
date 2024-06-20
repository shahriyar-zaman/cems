<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

$user_id = $_GET['id'];

// Check if there are any feedback or registrations for this user
$sql_check_feedback = "SELECT COUNT(*) as count FROM Feedback WHERE UserID = $user_id";
$result_feedback = mysqli_query($link, $sql_check_feedback);
$row_feedback = mysqli_fetch_assoc($result_feedback);

$sql_check_registrations = "SELECT COUNT(*) as count FROM Registrations WHERE UserID = $user_id";
$result_registrations = mysqli_query($link, $sql_check_registrations);
$row_registrations = mysqli_fetch_assoc($result_registrations);

if ($row_feedback['count'] > 0 || $row_registrations['count'] > 0) {
    // If there is feedback or registrations, display a message
    echo "<script>alert('Since the user has associated feedback or registrations, you can\'t delete them.'); window.location.href='manage_users.php';</script>";
} else {
    // If there is no feedback or registrations, proceed with deletion
    $sql_delete = "DELETE FROM Users WHERE UserID = $user_id";
    if (mysqli_query($link, $sql_delete)) {
        echo "<script>alert('User deleted successfully.'); window.location.href='manage_users.php';</script>";
    } else {
        echo "ERROR: Could not execute $sql_delete. " . mysqli_error($link);
    }
}
?>
