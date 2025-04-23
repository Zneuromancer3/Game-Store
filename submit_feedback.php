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

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert data into site_feedback table
    $sql = "INSERT INTO site_feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thank you for your feedback!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href='contact.html';</script>";
    }
}

$conn->close();
?>