<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management System</title>
    <link rel="stylesheet" href="/cems/css/styles.css">
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

        /* Header styles */
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
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
            font-size: 1em;
            background-color: #555;
            padding: 10px 20px;
            border-radius: 5px;
            margin-left: 20px;
            color: white;
        }
    </style>
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
                        <li><a href="/cems/public/index.php">Home</a></li>
                        <li><a href="/cems/public/events.php">Events</a></li>
                        <li><a href="/cems/user/index.php">Dashboard</a></li>
                        <li><a href="/cems/public/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/cems/public/index.php">Home</a></li>
                        <li><a href="/cems/public/events.php">Events</a></li>
                        <li><a href="/cems/public/login.php">Login</a></li>
                        <li><a href="/cems/public/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php if(isset($_SESSION['name'])): ?>
                <div class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
            <?php endif; ?>
        </div>
    </header>
    <main>
