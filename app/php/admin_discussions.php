<?php
require_once "config.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing discussion ID"]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM discussions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to delete"]);
    }
    exit;
}

http_response_code(405);
echo json_encode(["success" => false, "message" => "Invalid request method"]);
?>