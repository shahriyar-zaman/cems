<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

// Fetch all upcoming events
$current_date = date('Y-m-d');
$sql = "SELECT events.*, eventcategories.CategoryName, users.Name as OrganizerName, departments.DepartmentName FROM events 
        JOIN eventcategories ON events.CategoryID = eventcategories.CategoryID 
        JOIN users ON events.OrganizerID = users.UserID 
        JOIN departments ON events.DepartmentID = departments.DepartmentID
        WHERE events.Date >= '$current_date'
        ORDER BY events.Date ASC";
$result = mysqli_query($link, $sql);

?>

<?php include('../includes/header.php'); ?>
<h2>All Events</h2>
<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="events-container">
        <?php while ($row = mysqli_fetch_array($result)): ?>
            <div class="event-card">
                <h3><?php echo $row['Title']; ?></h3>
                <p><?php echo $row['Description']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['Date']; ?></p>
                <p><strong>Time:</strong> <?php echo $row['Time']; ?></p>
                <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                <p><strong>Category:</strong> <?php echo $row['CategoryName']; ?></p>
                <p><strong>Organizer:</strong> <?php echo $row['OrganizerName']; ?></p>
                <p><strong>Department:</strong> <?php echo $row['DepartmentName']; ?></p>
                <a href="register_event.php?id=<?php echo $row['EventID']; ?>" class="btn">Register</a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No upcoming events found.</p>
<?php endif; ?>
<?php include('../includes/footer.php'); ?>
