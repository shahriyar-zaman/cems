<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

$organizer_id = $_SESSION['id'];

$sql = "SELECT feedback.*, events.Title FROM Feedback 
        JOIN Events ON Feedback.EventID = Events.EventID 
        WHERE Events.OrganizerID = $organizer_id";
$result = mysqli_query($link, $sql);

include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .dashboard-container {
            margin: 20px;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .list-group-item a {
            color: #333;
            text-decoration: none;
        }
        .list-group-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h2 class="dashboard-header">Organizer Dashboard</h2>
        <div class="list-group">
            <a href="create_event.php" class="list-group-item list-group-item-action">Create Event</a>
            <a href="manage_events.php" class="list-group-item list-group-item-action">Manage My Events</a>
            <a href="view_event_feedback.php" class="list-group-item list-group-item-action">View Feedback</a>
            <a href="view_participants.php" class="list-group-item list-group-item-action">View Participants</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php'); ?>
