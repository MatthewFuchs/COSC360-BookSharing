<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

$myId = $_SESSION['user']['id'];
$otherId = intval($_GET['contact_id']);

$stmt = $conn->prepare("SELECT * FROM messagelog WHERE 
    (sending_userId = ? AND reciv_userId = ?) OR 
    (sending_userId = ? AND reciv_userId = ?)
    ORDER BY timeindex ASC");
$stmt->bind_param("iiii", $myId, $otherId, $otherId, $myId);
$stmt->execute();

$result = $stmt->get_result();
$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?>