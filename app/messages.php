<?php
session_start();
require_once 'php/config.php';
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/messages.css">
    <script src="js/messages.js" defer></script>
    <script>const currentUserId = <?= $userId ?>;</script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="message-container">
    <div class="contacts-list" id="contacts">
        <?php
        $stmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<div class='real_contact' id='{$row['id']}'>{$row['username']}</div>";
        }
        ?>
    </div>

    <div class="chat-panel">
        <div class="chatlog">
            <h2 id="chat-header">Select a conversation</h2>
        </div>

        <div class="textinput">
            <form id="messageForm" class="textinput">
                <textarea name="input_message" id="input_message" placeholder="Type a message..." required></textarea>
                <input type="hidden" name="replyinput" id="replyinput">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>

<?php include 'nav/footer.php'; ?>
</body>
</html>