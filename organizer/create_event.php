<?php
require_once '../includes/db.php';
session_start();

// Redirect to login page if user is not logged in or not an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $category_id = $_POST['category_id'];
    $organizer_id = $_SESSION['id'];
    $department_id = $_POST['department_id'];
    $recurrence_pattern = $_POST['recurrence_pattern'];

    $sql = "INSERT INTO events (Title, Description, Date, Time, Location, CategoryID, OrganizerID, DepartmentID, RecurrencePattern) 
            VALUES ('$title', '$description', '$date', '$time', '$location', '$category_id', '$organizer_id', '$department_id', '$recurrence_pattern')";
    
    if (mysqli_query($link, $sql)) {
        header("location: manage_events.php");
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
}

// Fetch categories and departments for the dropdowns
$sql_categories = "SELECT * FROM eventcategories";
$result_categories = mysqli_query($link, $sql_categories);

$sql_departments = "SELECT * FROM departments";
$result_departments = mysqli_query($link, $sql_departments);

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Create Event</h2>
    <form action="create_event.php" method="post">
        <label>Title:</label>
        <input type="text" name="title" required>
        
        <label>Description:</label>
        <textarea name="description" required></textarea>
        
        <label>Date:</label>
        <input type="date" name="date" required>
        
        <label>Time:</label>
        <input type="time" name="time" required>
        
        <label>Location:</label>
        <input type="text" name="location" required>
        
        <label>Category:</label>
        <select name="category_id" required>
            <?php while ($row_categories = mysqli_fetch_array($result_categories)): ?>
                <option value="<?php echo $row_categories['CategoryID']; ?>"><?php echo $row_categories['CategoryName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Department:</label>
        <select name="department_id" required>
            <?php while ($row_departments = mysqli_fetch_array($result_departments)): ?>
                <option value="<?php echo $row_departments['DepartmentID']; ?>"><?php echo $row_departments['DepartmentName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Recurrence Pattern:</label>
        <input type="text" name="recurrence_pattern">
        
        <input type="submit" value="Create Event">
    </form>
</div>

<?php include('../includes/footer.php'); ?>
