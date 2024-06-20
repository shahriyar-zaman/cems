<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../public/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['id'];
    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO feedback (EventID, UserID, FeedbackText, Rating, SubmissionDate) VALUES ($event_id, $user_id, '$feedback_text', $rating, NOW())";
    if (mysqli_query($link, $sql)) {
        $message = "Feedback submitted successfully.";
    } else {
        $message = "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
}

// Fetch events that the user has registered for and that have expired based on time and date
$sql_events = "SELECT events.EventID, events.Title FROM events
               JOIN registrations ON events.EventID = registrations.EventID
               WHERE registrations.UserID = {$_SESSION['id']} 
               AND (events.Date < CURDATE() OR (events.Date = CURDATE() AND events.Time < CURTIME()))";
$result_events = mysqli_query($link, $sql_events);

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Submit Feedback</h2>
    <?php if (isset($message)): ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="feedback.php" method="post">
        <label>Event:</label>
        <select name="event_id" required>
            <?php while ($row_events = mysqli_fetch_array($result_events)): ?>
                <option value="<?php echo $row_events['EventID']; ?>"><?php echo $row_events['Title']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Feedback:</label>
        <textarea name="feedback_text" required></textarea>
        <label>Rating:</label>
        <select name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="submit" value="Submit Feedback">
    </form>
</div>

<?php include('../includes/footer.php'); ?>
