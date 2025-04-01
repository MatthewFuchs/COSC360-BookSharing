<?php
require_once "config.php";
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$userId = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$userId || !in_array($action, ['enable', 'disable'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid parameters"]);
    exit;
}

$newStatus = $action === 'enable' ? 'enabled' : 'disabled';

$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->bind_param("si", $newStatus, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $stmt->error]);
}
?>