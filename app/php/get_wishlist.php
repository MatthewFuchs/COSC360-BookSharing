<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT book_id, book_title FROM wishlist WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlist = [];
while ($row = $result->fetch_assoc()) {
    $wishlist[] = $row;
}

header("Content-Type: application/json");
echo json_encode($wishlist);
?>