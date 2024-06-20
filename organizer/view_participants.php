<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    header("location: ../public/login.php");
    exit;
}

require_once '../includes/db.php';

$organizer_id = $_SESSION['id'];

$sql = "SELECT Users.Name AS ParticipantName, Users.Email, Events.Title AS EventTitle 
        FROM Registrations 
        JOIN Users ON Registrations.UserID = Users.UserID 
        JOIN Events ON Registrations.EventID = Events.EventID 
        WHERE Events.OrganizerID = $organizer_id 
        ORDER BY Events.EventID";
$result = mysqli_query($link, $sql);

$participants = [];
while ($row = mysqli_fetch_assoc($result)) {
    $participants[$row['EventTitle']][] = $row;
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
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
        }
        .table {
            margin-bottom: 0;
        }
        .participant-count {
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>
<body>
<main class="container mt-5">
    <h2 class="text-center mb-4">View Participants</h2>
    <?php foreach ($participants as $eventTitle => $participantList): ?>
        <div class="card">
            <div class="card-header">
                <?php echo $eventTitle; ?> <span class="participant-count">(<?php echo count($participantList); ?> participants)</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Participant Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participantList as $participant): ?>
                            <tr>
                                <td><?php echo $participant['ParticipantName']; ?></td>
                                <td><?php echo $participant['Email']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php'); ?>
