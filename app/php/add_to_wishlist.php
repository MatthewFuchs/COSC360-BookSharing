<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

$user_id = $_SESSION['user']['id'];
$book_id = $_POST['book_id'];
$title = $_POST['title'];
$notify = isset($_POST['notify']) && $_POST['notify'] == "true" ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO wishlist (user_id, book_id, book_title, notify)
    VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE notify = VALUES(notify)");
$stmt->bind_param("issi", $user_id, $book_id, $title, $notify);

if ($stmt->execute()) {
    echo "Wishlist updated.";
} else {
    http_response_code(500);
    echo "Database error: " . $stmt->error;
}
?>