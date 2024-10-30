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

// Add new fighter to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fighter_name = $_POST['fighter_name'];
    $belt_rank = $_POST['belt_rank'];
    $gym_affiliation = $_POST['gym_affiliation'];
    $instructor = $_POST['instructor'];

    $sql = "INSERT INTO fighters (name, belt_rank, gym, instructor) VALUES ('$fighter_name', '$belt_rank', '$gym_affiliation', '$instructor')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New fighter added successfully!');</script>";
    } else {
        if ($conn->errno == 1062) { // Duplicate entry error code
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
    <title>Fighters Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section with Navigation Links -->
    <div class="header">
        <h1>BJJ Fighter Database</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="fighters_page.php">Fighters</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
            </ul>
        </nav>
    </div>

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

    <style>
        /* Basic styling for header and navigation */
        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .header nav ul li {
            margin: 0 15px;
        }
        .header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .header nav ul li a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Close the database connection -->
    <?php $conn->close(); ?>
</body>
</html>
