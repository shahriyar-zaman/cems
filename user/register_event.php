<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../public/login.php");
    exit;
}

$message = '';

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    // Check if already registered
    $sql_check = "SELECT * FROM registrations WHERE EventID = $event_id AND UserID = $user_id";
    $result_check = mysqli_query($link, $sql_check);

    if (mysqli_num_rows($result_check) == 0) {
        $sql = "INSERT INTO registrations (EventID, UserID, RegistrationDate) VALUES ($event_id, $user_id, NOW())";
        if (mysqli_query($link, $sql)) {
            $message = "You have successfully registered for the event.";
        } else {
            $message = "ERROR: Could not execute $sql. " . mysqli_error($link);
        }
    } else {
        $message = "You are already registered for this event.";
    }
} else {
    header("location: view_events.php");
    exit;
}
?>

<?php include('../includes/header.php'); ?>

<div class="message-container">
    <p><?php echo $message; ?></p>
    <a href="view_events.php" class="btn">Back to Events</a>
</div>

<?php include('../includes/footer.php'); ?>
