<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

?>

<?php include('../includes/header.php'); ?>
<h2>Organizer Dashboard</h2>
<ul>
    <li><a href="create_event.php">Create Event</a></li>
    <li><a href="manage_events.php">Manage My Events</a></li>
</ul>
<?php include('../includes/footer.php'); ?>
