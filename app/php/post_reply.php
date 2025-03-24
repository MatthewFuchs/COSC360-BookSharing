<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$discussionId = $_POST['discussion_id'] ?? null;
$replyContent = trim($_POST['reply'] ?? '');

if (!$discussionId || empty($replyContent)) {
    header("Location: ../discussion.php?id=" . $discussionId . "&error=missing");
    exit;
}

$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("INSERT INTO replies (discussion_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $discussionId, $userId, $replyContent);

if ($stmt->execute()) {
    header("Location: ../discussion.php?id=" . $discussionId . "&success=1");
    exit;
} else {
    header("Location: ../discussion.php?id=" . $discussionId . "&error=db");
    exit;
}
?>