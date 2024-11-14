<?php
// Start session and check if the user is an admin
session_start();
if (!isset($_SESSION["role"]) || $_SESSION['role'] !== 'admin') {
    die('Access Denied!');
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
    $role = $_POST['role'] ?? 'user'; // Default to 'user' if no role is selected

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
                // Insert new user with role
                $insert_sql = "INSERT INTO Users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);

                if ($insert_stmt) {
                    $insert_stmt->bind_param("sssss", $first_name, $last_name, $email, $hashedPassword, $role);

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
    <title>Create an Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<!-- Header Section -->
<header class="header">
    <h1 class="site-title">Create User/Admin Account</h1>
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

<!-- Logout Button -->
<form action="logout.php" method="POST" style="display: inline;">
    <button type="submit">Logout</button>
</form>


<body>
    <div class="register-form">
        <form action="register.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">User Role:</label>
            <select id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">Create User</button>
        </form>
    </div>
</body>
</html>
