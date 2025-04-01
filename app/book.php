<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
include 'nav/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/book.css">
    <script src="js/headerMenu.js" defer></script>
    <script>
        const isLoggedIn = <?= json_encode($isLoggedIn) ?>;
    </script>
    <script defer src="js/book.js"></script>
</head>
<body>

<div class="book-container">
    <button id="back-btn" onclick="window.history.back();">Back</button>
    <div id="book-details"></div>

    <!-- Wishlist & Notify Buttons -->
    <?php if ($isLoggedIn): ?>
    <div class="book-actions">
        <button id="wishlist-btn" onclick="addToWishlist()">Add to Wishlist</button>
        <button id="notify-btn" onclick="notifyWhenAvailable()">Notify Me</button>
    </div>
    <?php endif; ?>

    <!-- Borrow Listings Section -->
    <div id="borrow-listings-section">
        <h2>Available for Borrowing</h2>
        <div id="borrow-listings"></div>
    </div>
</div>

<?php include 'nav/footer.php'; ?>
</body>
</html>