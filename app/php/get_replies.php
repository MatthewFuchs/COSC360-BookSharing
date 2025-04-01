<?php
require_once 'config.php';
header('Content-Type: application/json');

$discussionId = $_GET['discussion_id'] ?? null;

if (!$discussionId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing discussion ID']);
    exit;
}

$stmt = $conn->prepare("SELECT r.content, r.created_at, u.username 
                        FROM replies r 
                        JOIN users u ON r.user_id = u.id 
                        WHERE r.discussion_id = ? 
                        ORDER BY r.created_at ASC");
$stmt->bind_param("i", $discussionId);
$stmt->execute();
$replies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode($replies);
?>