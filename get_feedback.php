<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch feedback from the site_feedback table
$sql = "SELECT name, email, message, submitted_at FROM site_feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);

$feedback = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($feedback);

$conn->close();
?>