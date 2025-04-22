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

// Validate user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password === $user['password']) { // Compare plain text passwords
        echo "success"; // Send success response to frontend
    } else {
        http_response_code(401); // Set HTTP status code for invalid password
        echo "Invalid password";
    }
} else {
    http_response_code(404); // Set HTTP status code for user not found
    echo "User not found";
}

$stmt->close();
$conn->close();
?>