<?php include 'nav/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/browse.css">
    <script src="js/headerMenu.js" defer></script>
    <script defer src="js/searchBooks.js"></script>
</head>
<body>

    <!-- Search Bar -->
    <section class="search-bar">
        <input type="text" id="search-input" placeholder="ISBN, Author or Title">
        <select id="category-filter">
            <option value="all">All</option>
            <option value="fiction">Fiction</option>
            <option value="non-fiction">Non-Fiction</option>
            <option value="mystery">Mystery & Thriller</option>
            <option value="fantasy">Fantasy & Science Fiction</option>
            <option value="romance">Romance</option>
            <option value="self-help">Self-Help & Personal Development</option>
            <option value="health">Health & Wellness</option>
            <option value="poetry">Poetry</option>
        </select>
        <button id="search-btn">Search</button>
    </section>

    <!-- Search Status -->
    <p id="search-status" class="search-status">Searching...</p>

    <!-- Book Listings -->
    <section class="book-grid">
        <p>Loading books...</p>
    </section>

    <!-- Pagination Controls -->
    <div class="pagination">
        <button id="prev-page" disabled>Previous</button>
        <span id="page-number">Page 1</span>
        <button id="next-page">Next</button>
    </div>

    <?php include 'nav/footer.php'; ?>

</body>
</html>