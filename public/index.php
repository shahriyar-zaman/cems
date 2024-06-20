<?php
require_once '../includes/db.php';
session_start();

// Fetch upcoming events
$sql_upcoming = "SELECT * FROM events WHERE Date >= CURDATE() ORDER BY Date ASC LIMIT 6";
$result_upcoming = mysqli_query($link, $sql_upcoming);

// Fetch past events
$sql_past = "SELECT * FROM events WHERE (Date < CURDATE() OR (Date = CURDATE() AND Time < CURTIME())) ORDER BY Date DESC LIMIT 6";
$result_past = mysqli_query($link, $sql_past);

include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cems/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="/cems/js/scripts.js" defer></script>
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        header {
            background-color: #333;
            color: white;
            padding: 1em 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 50px;
            margin-right: 15px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            margin: 0;
            font-size: 1.5em;
            line-height: 1.2;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.9em;
            line-height: 1.2;
        }

        nav {
            flex-grow: 1;
            text-align: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #444;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #555;
        }

        .user-name {
            margin-left: 20px;
            font-size: 1em;
        }

        .hero {
            position: relative;
            height: 300px;
            overflow: hidden;
            background: url('../images/update_campus_event_audi.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 50px 20px;
        }

        .hero-image {
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
            border: 5px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .hero h2 {
            font-size: 2.5em;
            margin: 0;
        }

        .hero p {
            font-size: 1.2em;
            margin: 10px 0 20px;
        }

        main {
            flex: 1;
            padding: 20px;
            width: 80%;
            margin: 0 auto;
            max-width: 1200px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: auto;
        }

        .events, .past-events, .testimonials, .contact {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .events h2, .past-events h2, .testimonials h2, .contact h2 {
            text-align: center;
            color: #333;
            font-size: 2em;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .event-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .event-item {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px; /* Fixed height for all event boxes */
        }

        .event-item h3 {
            margin-top: 0;
        }

        .event-item p {
            margin: 10px 0;
            flex-grow: 1; /* Make the description take up remaining space */
        }

        .event-item .btn-register {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            align-self: flex-end; /* Align the button to the bottom */
        }

        .event-item .btn-register:hover {
            background-color: #0056b3;
        }

        .event-item .event-time {
            display: flex;
            align-items: center;
            font-size: 0.9em;
            color: #777;
        }

        .event-item .event-time i {
            margin-right: 5px;
        }

        .testimonials {
            padding: 20px;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .testimonials blockquote {
            margin: 0;
            padding: 10px;
            border-left: 5px solid #ccc;
            background-color: #fff;
            font-style: italic;
        }

        .contact {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .contact a {
            color: #333;
            text-decoration: none;
        }

        .contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<main class="container">
    <section class="hero my-5">
        <div class="hero-image">
            <h2>Organize, manage, and track all campus events seamlessly.</h2>
            <!-- <p>Organize, manage, and track all campus events seamlessly.</p>g -->
        </div>
    </section>
    <nav class="my-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-upcoming-tab" data-toggle="tab" href="#nav-upcoming" role="tab" aria-controls="nav-upcoming" aria-selected="true">Upcoming Events</a>
            <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab" aria-controls="nav-past" aria-selected="false">Past Events</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-upcoming" role="tabpanel" aria-labelledby="nav-upcoming-tab">
            <div class="row">
                <?php if (mysqli_num_rows($result_upcoming) > 0): ?>
                    <?php while ($row = mysqli_fetch_array($result_upcoming)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card event-item">
                                <div class="event-image" style="background-image: url('../images/event_default.jpg');"></div>
                                <div class="event-content">
                                    <h3><?php echo $row['Title']; ?></h3>
                                    <p><?php echo $row['Description']; ?></p>
                                    <div class="event-time">
                                        <i class="far fa-clock"></i> <strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?>
                                    </div>
                                    <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                                    <a class="btn btn-register" href="../user/register_event.php?id=<?php echo $row['EventID']; ?>">Register</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="col-12">No upcoming events.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
            <div class="row">
                <?php if (mysqli_num_rows($result_past) > 0): ?>
                    <?php while ($row = mysqli_fetch_array($result_past)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card event-item">
                                <div class="event-image" style="background-image: url('../images/event_default.jpg');"></div>
                                <div class="event-content">
                                    <h3><?php echo $row['Title']; ?></h3>
                                    <p><?php echo $row['Description']; ?></p>
                                    <div class="event-time">
                                        <i class="far fa-clock"></i> <strong>Date:</strong> <?php echo $row['Date']; ?> <strong>Time:</strong> <?php echo $row['Time']; ?>
                                    </div>
                                    <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="col-12">No past events.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- <section class="testimonials mt-5">
        <h2>What Our Users Say</h2>
        <blockquote>
            <p>"This platform has made organizing events so much easier. Highly recommend!" - Jane Doe</p>
        </blockquote>
        <blockquote>
            <p>"A must-have tool for any campus event. Great features and easy to use." - John Smith</p>
        </blockquote>
    </section> -->
    <section class="contact mt-5">
        <h2>CONTACT US</h2>
        <p>Reach out to us at <br>
        <a href="mailto:shahriyar.ridoy@northsouth.edu">shahriyar.ridoy@northsouth.edu</a><br>
        <a href="mailto:koushik.tonmoy@northsouth.edu">koushik.tonmoy@northsouth.edu</a>
        </p>
    </section>
</main>
<?php include('../includes/footer.php'); ?>
</body>
</html>
