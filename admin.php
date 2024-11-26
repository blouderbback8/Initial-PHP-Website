<?php 
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
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
            $fighter_id = $conn->insert_id;

            // Find or create school in the Schools table
            $school_sql = "SELECT school_id FROM Schools WHERE name = '$school_name'";
            $school_result = $conn->query($school_sql);
            if ($school_result->num_rows > 0) {
                $school_row = $school_result->fetch_assoc();
                $school_id = $school_row['school_id'];
            } else {
                $conn->query("INSERT INTO Schools (name) VALUES ('$school_name')");
                $school_id = $conn->insert_id;
            }

            $conn->query("INSERT INTO fighter_affiliations (fighter_id, school_id) VALUES ('$fighter_id', '$school_id')");
            echo "<script>alert('New fighter and school affiliation added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding fighter: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields with valid data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BJJ Fighter Management</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Management</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Index Page</a></li>
                <li><a href="register.php">Create a New User</a></li>
            </ul>
        </nav>
    </header>

        <!-- Logout Button Section -->
        <div class="logout-button-container">
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Modal for Adding Fighter -->
    <div id="fighterModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()"></span>
            <form action="" method="POST" onsubmit="return validateAge()" class="fighter-form">
                <input type="hidden" name="add_fighter" value="1">
                <input type="text" name="fighter_name" placeholder="Fighter Name" required>
                <select name="belt_rank" required>
                    <option value="">Select Belt Rank</option>
                    <option value="white">White</option>
                    <option value="blue">Blue</option>
                    <option value="purple">Purple</option>
                    <option value="brown">Brown</option>
                    <option value="black">Black</option>
                    <option value="Coral">Coral</option>
                    <option value="Red">Red</option>
                </select>
                <input type="text" id="ageInput" name="age" placeholder="Age" required>
                <input type="text" name="gender" placeholder="Gender" required>
                <input type="text" name="school_name" placeholder="School Name" required>
                <button type="submit">Add Fighter</button>
                <p id="ageError" style="color: red; display: none;">Please enter a valid number for age.</p>
            </form>
        </div>
    </div>

    <!-- Fighter Profiles Table Section -->
    <div class="fighter-list">
        <h3>Fighter Profiles</h3>
        <table id="fighterTable">
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
                $sql = "SELECT Fighters.fighter_id, Fighters.name, Fighters.belt_rank, Fighters.age, Fighters.gender, Schools.name AS school_name 
                        FROM Fighters
                        LEFT JOIN fighter_affiliations ON Fighters.fighter_id = fighter_affiliations.fighter_id
                        LEFT JOIN Schools ON fighter_affiliations.school_id = Schools.school_id";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-id='" . $row['fighter_id'] . "'>";
                        echo "<td contenteditable='true' class='editable' data-field='name'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td contenteditable='true' class='editable' data-field='belt_rank'>" . htmlspecialchars($row['belt_rank']) . "</td>";
                        echo "<td contenteditable='true' class='editable' data-field='age'>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td contenteditable='true' class='editable' data-field='gender'>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td contenteditable='true' class='editable' data-field='school_name'>" . htmlspecialchars($row['school_name']) . "</td>";
                        echo "<td>";
                        echo "<button class='save-btn'>Save</button>";
                        echo "<form action='delete_fighter.php' method='POST' style='display:inline;'>";
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

    <!-- Footer Section -->
    <footer class="footer">
        Contact us at: info@bjjtrackingsystem.example.com
    </footer>

    <script>
        function validateAge() {
            const ageInput = document.getElementById('ageInput');
            const ageError = document.getElementById('ageError');
            const ageValue = ageInput.value.trim();

            if (!/^\d+$/.test(ageValue)) {
                ageError.style.display = 'block';
                return false;
            }

            ageError.style.display = 'none';
            return true;
        }

        function openModal() {
            document.getElementById("fighterModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("fighterModal").style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById("fighterModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        $(document).on('click', '.save-btn', function() {
            const row = $(this).closest('tr');
            const fighterId = row.data('id');
            const data = {};

            row.find('.editable').each(function() {
                const field = $(this).data('field');
                const value = $(this).text().trim();
                data[field] = value;
            });

            $.ajax({
                url: 'update_fighter.php',
                type: 'POST',
                data: { fighter_id: fighterId, ...data },
                success: function(response) {
                    alert(response);
                },
                error: function() {
                    alert('Failed to save changes. Please try again.');
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
