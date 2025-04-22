<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$username = $_POST['username'];
$password = $_POST['password'];

// Debugging: Log the received POST data
error_log("POST data: " . print_r($_POST, true));

// Check if user already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "User already exists";
} else {
    // Insert user with plain text password
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password); // Store plain text password

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Debugging: Log the username and password being inserted
error_log("Username: $username, Password: $password");

$stmt->close();
$conn->close();
?>