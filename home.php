<?php
// Start session
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
    <script>
        function openModal() {
            document.getElementById("signUpModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("signUpModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("signUpModal");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Tracker</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Fighter Index</a></li>
                <li><a href="about.php">About this site</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    
        <!-- Sign Up Button -->
        <button onclick="openModal()">Sign Up</button>
    </div>

    <!-- Modal Structure for Sign-Up -->
    <div id="signUpModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Create an Account</h2>
            <form method="POST" action="home.php">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="register">Create Account</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <section class="intro">
            <p>Explore comprehensive profiles, track belt ranks, and connect with gym affiliations in our BJJ Fighter Database.</p>
        </section>

        <div class="main-content">
        <section class="overview">
            <video width="800" controls>
                <source src="Home%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>

        <section class="features">
            <h2>Features</h2>
            <ul>
                <li>Access fighter profiles with detailed stats</li>
                <li>Filter fighters by belt rank, gym affiliation, and more</li>
                <li>Search for fighters by name or rank</li>
                <li>Admin-only options to add, edit, and delete fighter records</li>
            </ul>
        </section>


    <div class="footer">
        Contact us at: info@bjjtrackingsystem.example.com
    </div>
</body>
</html>
