<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
?>
<link rel="stylesheet" href="css/header.css">
<div class="header">
    <h1><a href="index.php">BookTrade</a></h1>
    <div class="menu-toggle">☰</div>
    <div class="tnav">
        <a href="index.php">Home</a>
        <a href="browse.php">Browse Books</a>
        <a href="community.php">Community</a>

        <?php if ($user): ?>
            <a href="messages.php">Messages</a>
            <a href="mylistings.php">My Listings</a>
            <?php if ($user['role'] === 'admin'): ?>
                <a href="admin.php">Admin Dashboard</a>
            <?php endif; ?>
            <a href="notifications.php">Notifications</a>
            <a href="profile.php">Profile</a>
            <a href="php/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login / Sign Up</a>
        <?php endif; ?>
    </div>
</div>
<script src="js/headerMenu.js" defer></script>