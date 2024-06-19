<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

$organizer_id = $_SESSION['id'];

$sql = "SELECT feedback.*, events.Title FROM feedback 
        JOIN events ON feedback.EventID = events.EventID 
        WHERE events.OrganizerID = $organizer_id";
$result = mysqli_query($link, $sql);
?>

<?php include('../includes/header.php'); ?>
<h2>Organizer Dashboard</h2>
<ul>
    <li><a href="create_event.php">Create Event</a></li>
    <li><a href="manage_events.php">Manage My Events</a></li>
    <li><a href="view_event_feedback.php">View Feedback</a></li>
</ul>



<?php include('../includes/footer.php'); ?>
