<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$logFile = __DIR__ . '/debug_log.txt';

// Log raw input
file_put_contents($logFile, "Raw Input: " . file_get_contents('php://input') . "\n", FILE_APPEND);

$data = json_decode(file_get_contents('php://input'), true);

// Log decoded data
file_put_contents($logFile, "Decoded Data: " . json_encode($data) . "\n", FILE_APPEND);

if (!isset($data['user_id'], $data['game_id'])) {
    // Log missing fields
    file_put_contents($logFile, "Error: Missing user_id or game_id\n", FILE_APPEND);

    echo json_encode([
        "error" => "Invalid input",
        "received_payload" => $data
    ]);
    exit;
}

// Debugging: Log the received payload
$logFile = __DIR__ . '/debug_log.txt';

// Test write to ensure the file can be created
file_put_contents($logFile, "Test log entry\n", FILE_APPEND);

file_put_contents($logFile, "Received payload: " . json_encode($data) . "\n", FILE_APPEND);

$user_id = $conn->real_escape_string($data['user_id']);
$game_id = $conn->real_escape_string($data['game_id']);
$quantity = isset($data['quantity']) ? $conn->real_escape_string($data['quantity']) : 1;

$sql = "INSERT INTO cart (user_id, game_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $game_id, $quantity, $quantity);

// Debugging: Log the SQL query
file_put_contents($logFile, "SQL Query: " . $sql . "\n", FILE_APPEND);

if ($stmt->execute()) {
    echo json_encode(["success" => "Game added to cart"]);
} else {
    echo json_encode(["error" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>