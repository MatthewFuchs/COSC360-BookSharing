<?php
require_once 'config.php';

header('Content-Type: application/json');

$sql = "SELECT d.id, d.title, d.created_at, u.username 
        FROM discussions d 
        JOIN users u ON d.user_id = u.id 
        ORDER BY d.created_at DESC 
        LIMIT 20";

$result = $conn->query($sql);
$discussions = [];

while ($row = $result->fetch_assoc()) {
    $discussions[] = $row;
}

echo json_encode($discussions);
?>