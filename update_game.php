<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['name'], $data['image_url'], $data['price'], $data['description'])) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$name = $conn->real_escape_string($data['name']);
$image_url = $conn->real_escape_string($data['image_url']);
$price = $conn->real_escape_string($data['price']);
$description = $conn->real_escape_string($data['description']);

$sql = "UPDATE games SET name='$name', image_url='$image_url', price='$price', description='$description' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "Game updated successfully"]);
} else {
    echo json_encode(["error" => "Error updating game: " . $conn->error]);
}

$conn->close();
?>