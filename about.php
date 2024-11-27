<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - BJJ Fighter Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Database</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Fighter Index</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>
        <!-- Logout Button Section -->
        <div class="logout-button-container">
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="main-content">
        <section class="overview">
            <h2>Project Overview</h2>
            <!-- Video Embedding -->
            <video width="800" controls>
                <source src="About%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
    </div>

</body>

</html>