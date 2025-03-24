<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'You must be logged in to start a discussion.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$title = trim($data['title'] ?? '');
$content = trim($data['content'] ?? '');

if (empty($title) || empty($content)) {
    http_response_code(400);
    echo json_encode(['error' => 'Title and content are required.']);
    exit;
}

$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("INSERT INTO discussions (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iss", $userId, $title, $content);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'discussion_id' => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create discussion.']);
}
?>