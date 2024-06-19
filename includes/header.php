<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management System</title>
    <link rel="stylesheet" href="/cems/css/styles.css">
    <script src="/cems/js/scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>Campus Event Management System</h1>
        <nav>
            <ul>
                <li><a href="/cems/public/index.php">Home</a></li>
                <?php if(isset($_SESSION['id'])): ?>
                    <li><a href="/cems/user/index.php">Dashboard</a></li>
                    <li><a href="/cems/public/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/cems/public/login.php">Login</a></li>
                    <li><a href="/cems/public/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
