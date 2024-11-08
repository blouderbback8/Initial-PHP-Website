<?php
// Secure session for admin access
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
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

// Deleting a fighter with prepared statement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fighter_id'])) {
    $fighter_id = $_POST['fighter_id'];
    $sql = "DELETE FROM Fighters WHERE fighter_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $fighter_id);
        if ($stmt->execute()) {
            echo "<script>alert('Fighter deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting record');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing delete statement');</script>";
    }
}

// Redirect back to fighters_page.php
header("Location: fighters_page.php");
exit();
