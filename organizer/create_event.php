<?php
require_once '../includes/db.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

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
        // Fetch all users to send the email notification
        $sql_users = "SELECT Email FROM users WHERE RoleID IN (1, 3)"; // Assuming roles 1 and 3 are for students and faculty
        $result_users = mysqli_query($link, $sql_users);

        if ($result_users) {
            $emails = [];
            while ($row_users = mysqli_fetch_array($result_users)) {
                $emails[] = $row_users['Email'];
            }

            // Send email to all users
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;
                $mail->Username = 'shahriyar.ridoy01@gmail.com'; // SMTP username
                $mail->Password = 'kxsmiirqouybqezk'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to

                //Recipients
                $mail->setFrom('shahriyar.ridoy01@gmail.com', 'Event Management System');
                foreach ($emails as $email) {
                    $mail->addAddress($email);
                }

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'New Event Created: ' . $title;
                $mail->Body    = "<p>A new event has been created.</p>
                                  <p><strong>Title:</strong> $title</p>
                                  <p><strong>Description:</strong> $description</p>
                                  <p><strong>Date:</strong> $date</p>
                                  <p><strong>Time:</strong> $time</p>
                                  <p><strong>Location:</strong> $location</p>";

                if ($mail->send()) {
                    echo 'Emails have been sent successfully';
                } else {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "ERROR: Could not execute $sql_users. " . mysqli_error($link);
        }

        header("location: manage_events.php");
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
}

// Fetch categories and departments for the dropdowns
$sql_categories = "SELECT * FROM eventcategories";
$result_categories = mysqli_query($link, $sql_categories);
if (!$result_categories) {
    die('Error fetching categories: ' . mysqli_error($link));
}

$sql_departments = "SELECT * FROM departments";
$result_departments = mysqli_query($link, $sql_departments);
if (!$result_departments) {
    die('Error fetching departments: ' . mysqli_error($link));
}

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
