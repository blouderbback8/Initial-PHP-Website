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

// Add new person (fighter) to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fighter_name = $_POST['fighter_name'];
    $belt_rank = $_POST['belt_rank'];

    $sql = "INSERT INTO Fighters (name, belt_rank) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fighter_name, $belt_rank);

    if ($stmt->execute()) {
        echo "<script>alert('New fighter added successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
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
    <div class="header">Fighters Page - BJJ System</div>

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
                <button type="submit">Add Fighter</button>
            </form>
        </div>
    </div>

    <div class="footer">Contact us at: info@bjjfightersystem.com</div>
</body>
</html>
 
<?php
$conn->close();
?>
