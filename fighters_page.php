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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_fighter'])) {
    $fighter_name = $_POST['fighter_name'] ?? null;
    $belt_rank = $_POST['belt_rank'] ?? null;
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $school_name = $_POST['school_name'] ?? null;

    if ($fighter_name && $belt_rank && is_numeric($age) && $gender && $school_name) {
        $sql = "INSERT INTO Fighters (name, belt_rank, age, gender) VALUES ('$fighter_name', '$belt_rank', '$age', '$gender')";
        if ($conn->query($sql) === TRUE) {
            // Insert into Fighters table succeeded, now insert school affiliation
            $fighter_id = $conn->insert_id;  // Get the last inserted fighter ID
            
            // Find or create school in the Schools table
            $school_sql = "SELECT school_id FROM Schools WHERE name = '$school_name'";
            $school_result = $conn->query($school_sql);

            if ($school_result->num_rows > 0) {
                // School exists, get its ID
                $school_row = $school_result->fetch_assoc();
                $school_id = $school_row['school_id'];
            } else {
                // School doesn't exist, create it
                $conn->query("INSERT INTO Schools (name) VALUES ('$school_name')");
                $school_id = $conn->insert_id;
            }
            
            // Insert into fighter_affiliations
            $conn->query("INSERT INTO fighter_affiliations (fighter_id, school_id) VALUES ('$fighter_id', '$school_id')");

            echo "<script>alert('New fighter and school affiliation added successfully!');</script>";
        } else {
            if ($conn->errno == 1062) {
                echo "<script>alert('Error: Fighter with this name already exists.');</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "<script>alert('Please fill in all fields with valid data.');</script>";
    }
}

// Deleting a fighter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_fighter'])) {
    $fighter_id = $_POST['fighter_id'];
    $sql = "DELETE FROM Fighters WHERE fighter_id = $fighter_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Fighter deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
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
        <h1 class="site-title">BJJ Fighter Management</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Fighter Index</a></li>
                <li><a href="about.php">About this site</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="fighters_page.php">Manage Fighters</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="main">
        <!-- Add Fighter Form -->
        <div class="fighter-form">
            <h3>Add New Fighter Profile</h3>
            <form action="" method="POST" onsubmit="return validateAge()">
                <input type="hidden" name="add_fighter" value="1">
                <input type="text" name="fighter_name" placeholder="Fighter Name" required>
                <select name="belt_rank" required>
                    <option value="">Select Belt Rank</option>
                    <option value="white">White</option>
                    <option value="blue">Blue</option>
                    <option value="purple">Purple</option>
                    <option value="brown">Brown</option>
                    <option value="black">Black</option>
                </select>
                <input type="text" id="ageInput" name="age" placeholder="Age" required>
                <input type="text" name="gender" placeholder="Gender" required>
                <input type="text" name="school_name" placeholder="School Name" required>
                <button type="submit">Add Fighter</button>
                <p id="ageError" style="color: red; display: none;">Please enter a valid number for age.</p>
            </form>
        </div>

        <!-- Fighter List with Delete Button -->
        <div class="fighter-list">
            <h3>Fighter Profiles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Belt Rank</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>School</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch fighter details along with their current school
                    $sql = "SELECT Fighters.fighter_id, Fighters.name, Fighters.belt_rank, Fighters.age, Fighters.gender, Schools.name AS school_name 
                            FROM Fighters
                            LEFT JOIN fighter_affiliations ON Fighters.fighter_id = fighter_affiliations.fighter_id
                            LEFT JOIN Schools ON fighter_affiliations.school_id = Schools.school_id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['belt_rank']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                            echo "<td>" . (isset($row['school_name']) ? htmlspecialchars($row['school_name']) : "N/A") . "</td>";
                            echo "<td>";
                            // Delete button for each fighter
                            echo "<form action='' method='POST' style='display:inline;'>";
                            echo "<input type='hidden' name='fighter_id' value='" . $row['fighter_id'] . "'>";
                            echo "<button type='submit' name='delete_fighter'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No fighters found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        Contact us at: info@bjjtrackingsystem.example.com
    </div>

    <script>
        function validateAge() {
            const ageInput = document.getElementById('ageInput');
            const ageError = document.getElementById('ageError');
            const ageValue = ageInput.value.trim();

            if (!/^\d+$/.test(ageValue)) {  // Regex to check if input is all digits
                ageError.style.display = 'block';
                return false;  // Prevent form submission
            }

            ageError.style.display = 'none';  // Hide error if input is valid
            return true;  // Allow form submission
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
