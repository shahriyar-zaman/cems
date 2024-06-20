<?php
require_once '../includes/db.php';

// Fetch upcoming events
$sql_upcoming = "SELECT * FROM events WHERE Date >= CURDATE() ORDER BY Date ASC LIMIT 5";
$result_upcoming = mysqli_query($link, $sql_upcoming);

// Fetch past events
$sql_past = "SELECT * FROM events WHERE Date < CURDATE() ORDER BY Date DESC LIMIT 5";
$result_past = mysqli_query($link, $sql_past);

include('../includes/header.php');
?>

<main>
    <section class="hero">
        <!-- Changed: Added hero-image div for background image -->
        <div class="hero-image" style="background-image: url('../images/campus_event.jpg');">
            <h2>Welcome to Our Campus Event Management System</h2>
            <p>Organize, manage, and track all campus events seamlessly.</p>
        </div>
    </section>
    <section class="events">
        <h2>Upcoming Events</h2>
        <?php if(mysqli_num_rows($result_upcoming) > 0): ?>
            <ul class="event-list"><!-- Changed: Added class event-list -->
                <?php while($row = mysqli_fetch_array($result_upcoming)): ?>
                    <li class="event-item"><!-- Changed: Added class event-item -->
                        <h3><?php echo $row['Title']; ?></h3>
                        <p><?php echo $row['Description']; ?></p>
                        <p><strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?></p>
                        <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                        <a class="btn-register" href="../user/register_event.php?id=<?php echo $row['EventID']; ?>">Register</a><!-- Changed: Added class btn-register -->
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </section>
    <section class="past-events">
        <h2>Past Events</h2>
        <?php if(mysqli_num_rows($result_past) > 0): ?>
            <ul class="event-list"><!-- Changed: Added class event-list -->
                <?php while($row = mysqli_fetch_array($result_past)): ?>
                    <li class="event-item"><!-- Changed: Added class event-item -->
                        <h3><?php echo $row['Title']; ?></h3>
                        <p><?php echo $row['Description']; ?></p>
                        <p><strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?></p>
                        <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No past events.</p>
        <?php endif; ?>
    </section>
    <section class="testimonials">
        <h2>What Our Users Say</h2>
        <blockquote>
            <p>"This platform has made organizing events so much easier. Highly recommend!" - Jane Doe</p>
        </blockquote>
        <blockquote>
            <p>"A must-have tool for any campus event. Great features and easy to use." - John Smith</p>
        </blockquote>
    </section>
    <section class="contact">
        <h2>Contact Us</h2>
        <p>Have questions? Reach out to us at <a href="mailto:info@campuseventsystem.com">info@campuseventsystem.com</a>.</p>
    </section>
</main>

<?php include('../includes/footer.php'); ?>
