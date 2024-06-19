<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

?>

<?php include('../includes/header.php'); ?>
<h2>User Dashboard</h2>
<ul>
    <li><a href="view_events.php">View Events</a></li>
    <li><a href="feedback.php">Submit Feedback</a></li>
</ul>
<?php include('../includes/footer.php'); ?>
