<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$bookId = $data['book_id'] ?? null;
$title = $data['title'] ?? '';
$author = $data['author'] ?? '';
$thumbnail = $data['thumbnail'] ?? '';
$description = $data['description'] ?? '';

if (!$bookId || !$title) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required data']);
    exit;
}

$userId = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    INSERT INTO borrow_listings (user_id, book_id, title, author, thumbnail, description, posted_at) 
    VALUES (?, ?, ?, ?, ?, ?, NOW())
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("isssss", $userId, $bookId, $title, $author, $thumbnail, $description);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
}
?>