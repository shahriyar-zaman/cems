<?php if(mysqli_num_rows($result) > 0): ?>
    <ul>
        <?php while($row = mysqli_fetch_array($result)): ?>
            <li>
                <h3><?php echo $row['Title']; ?></h3>
                <p><?php echo $row['Description']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?></p>
                <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                <p><strong>Category:</strong> <?php echo $row['CategoryName']; ?></p>
                <p><strong>Organizer:</strong> <?php echo $row['OrganizerName']; ?></p>
                <p><strong>Department:</strong> <?php echo $row['DepartmentName']; ?></p>
                <a href="register_event.php?id=<?php echo $row['EventID']; ?>">Register</a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No events found.</p>
<?php endif; ?>
