<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

$event_id = $_GET['id'];

// Fetch event details
$sql = "SELECT * FROM events WHERE EventID = $event_id";
$result = mysqli_query($link, $sql);
$event = mysqli_fetch_array($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $category_id = $_POST['category_id'];
    $department_id = $_POST['department_id'];
    $recurrence_pattern = $_POST['recurrence_pattern'];

    $sql_update = "UPDATE events SET Title='$title', Description='$description', Date='$date', Time='$time', Location='$location', CategoryID='$category_id', DepartmentID='$department_id', RecurrencePattern='$recurrence_pattern' WHERE EventID = $event_id";
    
    if (mysqli_query($link, $sql_update)) {
        header("location: manage_events.php");
    } else {
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
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
    <h2>Edit Event</h2>
    <form action="edit_event.php?id=<?php echo $event_id; ?>" method="post">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $event['Title']; ?>" required>
        
        <label>Description:</label>
        <textarea name="description" required><?php echo $event['Description']; ?></textarea>
        
        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $event['Date']; ?>" required>
        
        <label>Time:</label>
        <input type="time" name="time" value="<?php echo $event['Time']; ?>" required>
        
        <label>Location:</label>
        <input type="text" name="location" value="<?php echo $event['Location']; ?>" required>
        
        <label>Category:</label>
        <select name="category_id" required>
            <?php while ($row_categories = mysqli_fetch_array($result_categories)): ?>
                <option value="<?php echo $row_categories['CategoryID']; ?>" <?php if ($event['CategoryID'] == $row_categories['CategoryID']) echo 'selected'; ?>><?php echo $row_categories['CategoryName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Department:</label>
        <select name="department_id" required>
            <?php while ($row_departments = mysqli_fetch_array($result_departments)): ?>
                <option value="<?php echo $row_departments['DepartmentID']; ?>" <?php if ($event['DepartmentID'] == $row_departments['DepartmentID']) echo 'selected'; ?>><?php echo $row_departments['DepartmentName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Recurrence Pattern:</label>
        <input type="text" name="recurrence_pattern" value="<?php echo $event['RecurrencePattern']; ?>">
        
        <input type="submit" value="Update Event">
    </form>
</div>

<?php include('../includes/footer.php'); ?>
