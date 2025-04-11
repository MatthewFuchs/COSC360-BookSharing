<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    exit;
}

$user_id = $_SESSION['user']['id'];
$book_id = $_POST['book_id'];

$stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND book_id = ?");
$stmt->bind_param("is", $user_id, $book_id);

if ($stmt->execute()) {
    echo "Removed from wishlist.";
} else {
    http_response_code(500);
    echo "Failed to remove item.";
}
?>