<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

// Fetch events
$sql = "SELECT events.*, eventcategories.CategoryName, users.Name as OrganizerName, departments.DepartmentName FROM events 
        JOIN eventcategories ON events.CategoryID = eventcategories.CategoryID 
        JOIN users ON events.OrganizerID = users.UserID 
        JOIN departments ON events.DepartmentID = departments.DepartmentID";
$result = mysqli_query($link, $sql);

?>

<?php include('../includes/header.php'); ?>
<h2>Manage My Events</h2>

<table>
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Category</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_array($result)): ?>
        <tr>
            <td><?php echo $row['Title']; ?></td>
            <td><?php echo $row['Date']; ?></td>
            <td><?php echo $row['Time']; ?></td>
            <td><?php echo $row['Location']; ?></td>
            <td><?php echo $row['CategoryName']; ?></td>
            <td><?php echo $row['DepartmentName']; ?></td>
            <td>
                <a href="edit_event.php?id=<?php echo $row['EventID']; ?>">Edit</a>
                <a href="delete_event.php?id=<?php echo $row['EventID']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php include('../includes/footer.php'); ?>
