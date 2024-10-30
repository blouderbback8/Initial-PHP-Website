<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Adding a new fighter
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fighter_name = $_POST['fighter_name'];
    $belt_rank = $_POST['belt_rank'];
    $gym_affiliation = $_POST['gym_affiliation'];
    $instructor = $_POST['instructor'];

    $sql = "INSERT INTO fighters (name, belt_rank, gym, instructor) VALUES ('$fighter_name', '$belt_rank', '$gym_affiliation', '$instructor')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New fighter added successfully!');</script>";
    } else {
        if ($conn->errno == 1062) {
            echo "<script>alert('Error: Fighter with this name already exists.');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BJJ Fighter Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">Admin-only ADD FIGHTER HERE</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Fighter Index</a></li>
                <li><a href="about.php">About this site</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="fighters_page.php">Add Fighters</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="main">
        <div class="fighter-form">
            <h3>Add New Fighter Profile (Admin Only)</h3>
            <form action="" method="POST">
                <input type="text" name="fighter_name" placeholder="Fighter Name" required>
                <select name="belt_rank">
                    <option value="">Select Belt Rank</option>
                    <option value="white">White</option>
                    <option value="blue">Blue</option>
                    <option value="purple">Purple</option>
                    <option value="brown">Brown</option>
                    <option value="black">Black</option>
                </select>
                <input type="text" name="gym_affiliation" placeholder="Gym Affiliation" required>
                <input type="text" name="instructor" placeholder="Instructor" required>
                <button type="submit">Add Fighter</button>
            </form>
        </div>
    </div>

    <div class="footer">
        Contact us at: info@bjjtrackingsystem.example.com
    </div>
</body>
</html>
