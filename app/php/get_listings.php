<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT id, book_id, title, author, thumbnail, description, posted_at FROM borrow_listings WHERE user_id = ? ORDER BY posted_at DESC");$stmt->bind_param("i", $userId);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $listings = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($listings);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch listings']);
}
?>