<?php
require_once '../includes/db.php';

// Fetch upcoming events
$sql = "SELECT * FROM events ORDER BY Date ASC LIMIT 5";
$result = mysqli_query($link, $sql);

include('../includes/header.php');
?>

<main>
    <section class="hero">
        <h2>Welcome to Our Campus Event Management System</h2>
        <p>Organize, manage, and track all campus events seamlessly.</p>
    </section>
    <section class="events">
        <h2>Upcoming Events</h2>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <ul>
                <?php while($row = mysqli_fetch_array($result)): ?>
                    <li>
                        <h3><?php echo $row['Title']; ?></h3>
                        <p><?php echo $row['Description']; ?></p>
                        <p><strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?></p>
                        <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                        <a href="../user/register_event.php?id=<?php echo $row['EventID']; ?>">Register</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </section>
    <section class="featured-events">
        <h2>Featured Events</h2>
        <div class="slider">
            <div class="slide">
                <img src="../images/event1.jpg" alt="Event 1">
                <h3>Annual Tech Symposium</h3>
            </div>
            <div class="slide">
                <img src="../images/event2.jpg" alt="Event 2">
                <h3>Science Fair 2024</h3>
            </div>
            <div class="slide">
                <img src="../images/event3.jpg" alt="Event 3">
                <h3>Cultural Fest</h3>
            </div>
        </div>
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

