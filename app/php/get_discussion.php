<?php
require_once 'config.php';
header('Content-Type: application/json');

$discussionId = $_GET['id'] ?? null;

if (!$discussionId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing discussion ID']);
    exit;
}

// Get the discussion
$stmt = $conn->prepare("SELECT d.id, d.title, d.content, d.created_at, u.username 
                        FROM discussions d 
                        JOIN users u ON d.user_id = u.id 
                        WHERE d.id = ?");
$stmt->bind_param("i", $discussionId);
$stmt->execute();
$discussion = $stmt->get_result()->fetch_assoc();

if (!$discussion) {
    http_response_code(404);
    echo json_encode(['error' => 'Discussion not found']);
    exit;
}

// Get the replies
$stmt = $conn->prepare("SELECT r.content, r.created_at, u.username 
                        FROM discussion_replies r 
                        JOIN users u ON r.user_id = u.id 
                        WHERE r.discussion_id = ? 
                        ORDER BY r.created_at ASC");
$stmt->bind_param("i", $discussionId);
$stmt->execute();
$replies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'discussion' => $discussion,
    'replies' => $replies
]);
?>