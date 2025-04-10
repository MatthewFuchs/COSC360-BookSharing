<?php

require_once 'config.php';

$txtContent = $_POST['input_message'] ?? '';

//$sending_userId = $_SESSION['user']['id'];
//$reciv_userId = 

$reciv_userId = 323; // placeholder
$sending_userId = 123; // placeholder

$stmt = $conn->prepare("INSERT INTO messagelog (sending_userId, reciv_userId, textmessage, timeindex) VALUES (?, ?, NOW())");
$stmt->bind_param("iss", $sending_userId, $reciv_userId, $txtContent);

if ($stmt->execute()) {
} else {
    echo "Error: " . $stmt->error;
}

?>