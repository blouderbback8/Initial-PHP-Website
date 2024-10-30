<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fighter_id'])) {
    $fighter_id = $_POST['fighter_id'];
    $sql = "DELETE FROM Fighters WHERE fighter_id = $fighter_id";
    if ($conn->query($sql) === TRUE) {
        echo "Fighter deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
