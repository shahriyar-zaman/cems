<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

$organizer_id = $_SESSION['id'];

$sql = "SELECT feedback.*, events.Title, users.Name FROM feedback 
        JOIN events ON feedback.EventID = events.EventID 
        JOIN users ON feedback.UserID = users.UserID 
        WHERE events.OrganizerID = $organizer_id";
$result = mysqli_query($link, $sql);
?>

<?php include('../includes/header.php'); ?>
<h2>Event Feedback</h2>
<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="feedback-container">
        <?php while ($row = mysqli_fetch_array($result)): ?>
            <div class="feedback-card">
                <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
                <p><strong>Submitted by:</strong> <?php echo htmlspecialchars($row['Name']); ?></p>
                <p><strong>Rating:</strong> <?php echo htmlspecialchars($row['Rating']); ?></p>
                <p><?php echo htmlspecialchars($row['FeedbackText']); ?></p>
                <p><strong>Submitted on:</strong> <?php echo htmlspecialchars($row['SubmissionDate']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No feedback found for your events.</p>
<?php endif; ?>
<?php include('../includes/footer.php'); ?>
