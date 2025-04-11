<?php
session_start();
include 'nav/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTrade - Notifications</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/notifications.css">
    <script src="js/headerMenu.js" defer></script>
    <script src="js/notifications.js" defer></script>
</head>
<body>

<div class="notification-page">
    <h1>Your Notifications</h1>
    <div id="notifications-container"></div>
</div>

<?php include 'nav/footer.php'; ?>
</body>
</html>