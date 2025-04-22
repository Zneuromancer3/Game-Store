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

if (!isset($_GET['user_id'])) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$user_id = $conn->real_escape_string($_GET['user_id']);

$sql = "SELECT c.game_id, g.name, g.price, g.image_url, c.quantity FROM cart c JOIN games g ON c.game_id = g.id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($cart);
?>