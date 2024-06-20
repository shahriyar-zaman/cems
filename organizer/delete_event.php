<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

$event_id = $_GET['id'];

// Check if there are any registrations for this event
$sql_check_registrations = "SELECT COUNT(*) as count FROM Registrations WHERE EventID = $event_id";
$result = mysqli_query($link, $sql_check_registrations);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    // If there are registrations, display a message
    echo "<script>alert('Since the event has already been registered by participants, you can\'t delete it.'); window.location.href='manage_events.php';</script>";
} else {
    // If there are no registrations, proceed with deletion
    $sql_delete = "DELETE FROM Events WHERE EventID = $event_id";
    if (mysqli_query($link, $sql_delete)) {
        echo "<script>alert('Event deleted successfully.'); window.location.href='manage_events.php';</script>";
    } else {
        echo "ERROR: Could not execute $sql_delete. " . mysqli_error($link);
    }
}
?>
