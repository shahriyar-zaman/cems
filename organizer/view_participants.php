<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

// Fetch events organized by the logged-in organizer
$organizer_id = $_SESSION['id'];
$sql_events = "SELECT EventID, Title FROM Events WHERE OrganizerID = $organizer_id";
$result_events = mysqli_query($link, $sql_events);

if (!$result_events) {
    die("SQL Error: " . mysqli_error($link));
}

include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Participants</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .event-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <main class="container">
        <h2>View Participants</h2>
        <?php while ($event = mysqli_fetch_array($result_events)): ?>
            <div class="event-container">
                <div class="event-header">
                    <?php echo $event['Title']; ?>
                    <?php
                    // Fetch participants for this event
                    $event_id = $event['EventID'];
                    $sql_participants = "SELECT Users.Name as ParticipantName, Users.Email 
                                         FROM Registrations 
                                         JOIN Users ON Registrations.UserID = Users.UserID 
                                         WHERE Registrations.EventID = $event_id";
                    $result_participants = mysqli_query($link, $sql_participants);
                    if (!$result_participants) {
                        die("SQL Error: " . mysqli_error($link));
                    }
                    $num_participants = mysqli_num_rows($result_participants);
                    echo " ({$num_participants} participants)";
                    ?>
                </div>
                <?php if ($num_participants > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Participant Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($participant = mysqli_fetch_array($result_participants)): ?>
                                <tr>
                                    <td><?php echo $participant['ParticipantName']; ?></td>
                                    <td><?php echo $participant['Email']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No participants registered for this event.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
