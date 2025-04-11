<?php
require_once '../php/config.php';

$sender = 1;
$receiver = 2;
$text = "Test message from server test";

$stmt = $conn->prepare("INSERT INTO messagelog (sending_userId, reciv_userId, textmessage, timeindex) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $sender, $receiver, $text);
$success = $stmt->execute();

echo "Messaging Test\n";
echo $success ? "Message inserted\n" : "Message insert failed\n";