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
        <div class="header-container">
            <div class="logo-container">
                <img src="/cems/images/logo.webp" alt="iNSUre Logo" class="logo">
                <div class="logo-text">
                    <h1>iNSUre</h1>
                    <p>A Campus Event Management System</p>
                </div>
            </div>
            <nav>
                <ul>
                    <?php if(isset($_SESSION['id']) && $_SESSION['role'] == 2): ?>
                        <li><a href="/cems/organizer/index.php">Dashboard</a></li>
                        <li><a href="/cems/public/logout.php">Logout</a></li>    
                    <?php elseif(isset($_SESSION['id']) && $_SESSION['role'] == 1): ?>
                        <li><a href="/cems/admin/index.php">Dashboard</a></li>
                        <li><a href="/cems/public/logout.php">Logout</a></li>
                    <?php elseif(isset($_SESSION['id']) && $_SESSION['role'] == 3): ?>
                        <li><a href="/cems/user/index.php">Dashboard</a></li>
                        <li><a href="/cems/public/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/cems/public/index.php">Home</a></li>
                        <li><a href="/cems/public/login.php">Login</a></li>
                        <li><a href="/cems/public/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
