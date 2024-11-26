<?php
// Start session
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Simple validation
    if ($first_name && $last_name && $email && $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $sql = "SELECT * FROM Users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                echo "<script>alert('Email already exists. Please choose another one.');</script>";
            } else {
                // Insert new user with a default 'user' role
                $insert_sql = "INSERT INTO Users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'user')";
                $insert_stmt = $conn->prepare($insert_sql);

                if ($insert_stmt) {
                    $insert_stmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);

                    if ($insert_stmt->execute()) {
                        echo "<script>alert('Account created successfully!');</script>";
                    } else {
                        echo "<script>alert('Error creating account: " . $insert_stmt->error . "');</script>";
                    }
                    $insert_stmt->close();
                } else {
                    echo "<script>alert('Error preparing insert statement: " . $conn->error . "');</script>";
                }
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing select statement: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BJJ Fighter Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Tracker</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="index.php">Fighter Index</a></li>
                <li><a href="about.php">About this site</a></li>
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
            <video width="800" controls>
                <source src="Home%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
    </div>
</body>
</html>
