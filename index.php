<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BJJ Fighter Lineage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>BJJ Fighter Lineage</h1>

    <!-- Dropdown to filter by belt rank -->
    <label for="beltFilter">Filter by Belt Rank:</label>
    <select id="beltFilter" onchange="filterBelt()">
        <option value="all">All</option>
        <option value="Black Belt">Black Belt</option>
        <option value="Red Belt">Red Belt</option>
        <option value="Coral Belt">Coral Belt</option>
    </select>

    <!-- Table to display BJJ fighters -->
    <table id="fighterTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Belt Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection settings
            $host = 'localhost';  
            $dbname = 'bjj_lineage';  
            $username = 'root';  
            $password = '';  

            // Create connection
            $conn = new mysqli($host, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch data from People table
            $sql = "SELECT * FROM People";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row with dynamic belt rank classes
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["person_id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td class='belt " . strtolower(str_replace(' ', '-', $row["belt_rank"])) . "'>" . $row["belt_rank"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No results found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <script src="script.js"></script>
</body>
</html>
