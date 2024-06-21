<?php
session_start();
require_once '../includes/db.php';
include('../includes/header.php');

// Fetch departments with their events
$sql_departments = "SELECT departments.DepartmentName, events.Title, events.Description, events.Date, events.Time, events.Location 
                    FROM departments 
                    LEFT JOIN events ON departments.DepartmentID = events.DepartmentID 
                    ORDER BY departments.DepartmentName, events.Date DESC, events.Time DESC";
$result_departments = mysqli_query($link, $sql_departments);

$departments = [];
while ($row = mysqli_fetch_assoc($result_departments)) {
    $departments[$row['DepartmentName']][] = $row;
}
?>

<main>
    <section class="events">
        <h2>Events by Department</h2>
        <?php foreach ($departments as $department => $events): ?>
            <div class="department">
                <h3 class="department-name" onclick="toggleEvents(this)">
                    <?php echo $department; ?><?php echo (count(array_filter($events, fn($event) => !empty($event['Title']))) > 0) ? ' (' . count(array_filter($events, fn($event) => !empty($event['Title']))) . ')' : ''; ?>
                </h3>
                <div class="event-list" style="display: none;">
                    <?php if (!empty($events[0]['Title'])): ?>
                        <ul>
                            <?php foreach ($events as $event): ?>
                                <li class="event-item">
                                    <h4><?php echo $event['Title']; ?></h4>
                                    <p><?php echo $event['Description']; ?></p>
                                    <p><strong>Date:</strong> <?php echo $event['Date']; ?> <strong>Time:</strong> <?php echo $event['Time']; ?></p>
                                    <p><strong>Location:</strong> <?php echo $event['Location']; ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No events available.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php include('../includes/footer.php'); ?>

<script>
    function toggleEvents(element) {
        const eventList = element.nextElementSibling;
        if (eventList.style.display === 'none' || eventList.style.display === '') {
            eventList.style.display = 'block';
        } else {
            eventList.style.display = 'none';
        }
    }
</script>

<style>
    .events {
        width: 80%;
        margin: 0 auto;
        max-width: 1200px;
    }
    .department {
        margin-bottom: 20px;
    }
    .department-name {
        cursor: pointer;
        background: #333;
        color: white;
        padding: 10px;
        border-radius: 5px;
    }
    .event-list {
        margin-top: 10px;
        padding-left: 20px;
    }
    .event-list ul {
        list-style: none;
        padding: 0;
    }
    .event-item {
        background: #fff;
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .event-item h4 {
        margin: 0 0 10px;
    }
    .event-item p {
        margin: 5px 0;
    }
    a {
        color: white;
        text-decoration: none;
    }
</style>
