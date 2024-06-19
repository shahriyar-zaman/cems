<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

?>

<?php include('../includes/header.php'); ?>
<h2>Admin Dashboard</h2>
<ul>
    <li><a href="manage_users.php">Manage Users</a></li>
    <li><a href="manage_events.php">Manage Events</a></li>
</ul>
<?php include('../includes/footer.php'); ?>
