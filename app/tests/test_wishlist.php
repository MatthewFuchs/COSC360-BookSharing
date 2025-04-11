<?php
require_once '../php/config.php';

$userId = 1;
$bookId = 'test-book-id-123';
$title = 'Test Book Title';

$conn->query("DELETE FROM wishlist WHERE user_id = $userId AND book_id = '$bookId'");
$stmt = $conn->prepare("INSERT INTO wishlist (user_id, book_id, book_title) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $userId, $bookId, $title);
$stmt->execute();

$res = $conn->query("SELECT * FROM wishlist WHERE user_id = $userId AND book_id = '$bookId'");
echo "Wishlist Add Test\n";
echo $res->num_rows === 1 ? "Book added\n" : "Book not added\n";

$conn->query("DELETE FROM wishlist WHERE user_id = $userId AND book_id = '$bookId'");