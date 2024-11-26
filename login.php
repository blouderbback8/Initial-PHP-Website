<?php
// Start a secure session
session_start();
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_secure', false); // Change to true in production with HTTPS
ini_set('session.use_only_cookies', true);

// Initialize variables for messages
$error = '';
$success = '';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No account found with that email address.";
        }
        $stmt->close();
    }
}

// Process signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($first_name && $last_name && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);
            if ($stmt->execute()) {
                $success = "Signup successful! You can now log in.";
            } else {
                $error = "Error: Unable to create account. Email might already be in use.";
            }
            $stmt->close();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup</title>
    <link rel="stylesheet" href="style.css">
    <script src="auth.js" defer></script>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Tracker</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <!-- Login/Signup Section -->
    <div class="wrapper">
        <!-- Display error/success messages -->
        <?php if (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success-message"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <div class="form-container">
            <div class="slide-controls">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <!-- Login Form -->
                <form action="login.php" method="POST" class="login">
                    <div class="field">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field btn">
                        <input type="submit" name="login" value="Login">
                    </div>
                </form>
                <!-- Signup Form -->
                <form action="login.php" method="POST" class="signup">
                    <div class="field">
                        <input type="text" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="field">
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field btn">
                        <input type="submit" name="register" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
