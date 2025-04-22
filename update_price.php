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

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$price = $data['price'];

$sql = "UPDATE games SET price = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $price, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => "Game price updated successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>