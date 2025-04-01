<?php
require_once "config.php";
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $id = $_POST['user_id'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $role = $_POST['role'] ?? null;

    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($existingRole);
    $stmt->fetch();
    $stmt->close();

    if ($existingRole === "admin") {
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, location=? WHERE id=?");
        $stmt->bind_param("sssi", $fullName, $email, $location, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, location=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $fullName, $email, $location, $role, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }
    exit;
}

if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing ID"]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }
    exit;
}

http_response_code(405);
echo json_encode(["success" => false, "message" => "Invalid request method"]);