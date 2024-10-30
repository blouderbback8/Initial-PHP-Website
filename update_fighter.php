<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bjj_lineage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fighter_id = $_POST['fighter_id'];
    $name = $_POST['name'];
    $belt_rank = $_POST['belt_rank'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $school_name = $_POST['school_name'];

    // Update Fighters table
    $updateFighterSql = "UPDATE Fighters SET name='$name', belt_rank='$belt_rank', age='$age', gender='$gender' WHERE fighter_id='$fighter_id'";
    $conn->query($updateFighterSql);

    // Update school information
    $schoolSql = "SELECT school_id FROM Schools WHERE name='$school_name'";
    $schoolResult = $conn->query($schoolSql);

    if ($schoolResult->num_rows > 0) {
        $schoolRow = $schoolResult->fetch_assoc();
        $school_id = $schoolRow['school_id'];
    } else {
        $conn->query("INSERT INTO Schools (name) VALUES ('$school_name')");
        $school_id = $conn->insert_id;
    }

    // Update affiliation
    $updateAffiliationSql = "UPDATE fighter_affiliations SET school_id='$school_id' WHERE fighter_id='$fighter_id'";
    $conn->query($updateAffiliationSql);

    echo "Fighter information updated successfully!";
}

$conn->close();
?>
