<?php if($event): ?>
    <h3><?php echo $event['Title']; ?></h3>
    <p><?php echo $event['Description']; ?></p>
    <p><strong>Date:</strong> <?php echo $event['Date']; ?> <strong>Time:</strong> <?php echo $event['Time']; ?></p>
    <p><strong>Location:</strong> <?php echo $event['Location']; ?></p>
    <p><strong>Category:</strong> <?php echo $event['CategoryName']; ?></p>
    <a href="register_event.php?id=<?php echo $event['EventID']; ?>">Register</a>
<?php else: ?>
    <p>Event not found.</p>
<?php endif; ?>
