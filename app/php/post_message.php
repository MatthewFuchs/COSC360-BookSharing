<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    exit;
}

$sender_id = $_SESSION['user']['id'];
$receiver_id = intval($_POST['replyinput']);
$message = trim($_POST['input_message']);

$sender_name = $_SESSION['user']['username']; 

if ($message !== '') {
    $stmt = $conn->prepare("INSERT INTO messagelog (sending_userId, reciv_userId, textmessage, timeindex) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    $notifMsg = "$sender_name sent you a new message.";
    $notify = $conn->prepare("INSERT INTO notifications (user_id, type, message) VALUES (?, 'message', ?)");
    $notify->bind_param("is", $receiver_id, $notifMsg);
    $notify->execute();
}
?>