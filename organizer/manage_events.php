<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

// Fetch events organized by the logged-in organizer
$organizer_id = $_SESSION['id'];
$sql = "SELECT Events.*, EventCategories.CategoryName, Departments.DepartmentName 
        FROM Events 
        JOIN EventCategories ON Events.CategoryID = EventCategories.CategoryID 
        JOIN Departments ON Events.DepartmentID = Departments.DepartmentID
        WHERE Events.OrganizerID = $organizer_id";
$result = mysqli_query($link, $sql);

include('../includes/header.php');
?>

<main>
    <h2>Manage My Events</h2>
    <div class="table-container">
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
    </div>
</main>

<?php include('../includes/footer.php'); ?>
