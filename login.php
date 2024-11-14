<?php 
// Secure session settings
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_secure', true);
ini_set('session.use_only_cookies', true);
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Retrieve the user with the given email
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Set session variables, including role
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role']; // Store the role (admin or user)

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: http://localhost/BJJ_Repo/Initial-PHP-Website/fighters_page.php");
                } else {
                    header("Location: http://localhost/BJJ_Repo/Initial-PHP-Website/index.php");
                }
                exit();
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('Email not found.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing select statement: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>

<!-- Header Section -->
<header class="header">
    <h1 class="site-title">Login Page for the BJJ Fighter Tracker</h1>
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

<br>
<div class="login-form">
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>
<br></br>
<!-- Video Embedding Section -->
<section class="overview">
    <video width="800" controls>
        <source src="Login%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</section>

</body>
</html>
