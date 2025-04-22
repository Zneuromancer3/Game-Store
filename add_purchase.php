<?php
require_once 'db_connection.php'; // Ensure this file contains the database connection logic

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['user_id'], $data['cart'])) {
        $user_id = $data['user_id'];
        $cart = $data['cart'];

        $conn = getDatabaseConnection(); // Assuming this function is defined in db_connection.php

        $stmt = $conn->prepare("INSERT INTO purchased_games (user_id, game_id, quantity) VALUES (?, ?, ?)");

        foreach ($cart as $item) {
            $stmt->bind_param('iii', $user_id, $item['game_id'], $item['quantity']);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        echo json_encode(['status' => 'success', 'message' => 'Purchase recorded successfully.']);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>