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
                <li><a href="about.php">About this site</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <section class="overview">
            <h2>Project Overview</h2>
            <!-- Video Embedding -->
            <video width="800" controls>
                <source src="About%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>

        <section class="credits">
            <h2>Credits</h2>
            <p>This project was created as part of the IS330 Databases and Data Analysis course. Special thanks to any
                mentors, instructors, or resources that provided guidance during the project development.</p>
        </section>
    </div>

    <div class="footer">
        Contact us at: info@bjjtrackingsystem.example.com
    </div>
</body>

</html>