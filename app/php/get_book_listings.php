<?php
require_once 'config.php';
header('Content-Type: application/json');

$bookId = $_GET['book_id'] ?? null;

if (!$bookId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing book ID']);
    exit;
}

$stmt = $conn->prepare("
    SELECT b.id, b.user_id, b.book_id, b.title, b.author, b.thumbnail, b.description, b.posted_at, u.username 
    FROM borrow_listings b 
    JOIN users u ON b.user_id = u.id 
    WHERE b.book_id = ?
    ORDER BY b.posted_at DESC
");

$stmt->bind_param("s", $bookId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $listings = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($listings);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch listings']);
}
?>