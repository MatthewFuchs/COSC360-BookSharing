<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Listings | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mylistings.css">
    <script src="js/headerMenu.js" defer></script>
    <script src="js/mylistings.js" defer></script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="mylistings-container">
    <h1>Borrow Listings</h1>

    <!-- Search Section -->
    <div class="search-section">
        <input type="text" id="search-input" placeholder="Search books to post..." />
        <button id="search-btn">Search</button>
    </div>

    <!-- Google Books Search Results -->
    <div class="book-grid" id="search-results"></div>

    <!-- Divider -->
    <hr style="margin: 2em 0;">

    <!-- Current Listings -->
    <h2>Your Current Listings</h2>
    <div class="book-grid" id="user-listings">
        <!-- User listings will be populated here -->
    </div>
</div>

<?php include 'nav/footer.php'; ?>
</body>
</html>