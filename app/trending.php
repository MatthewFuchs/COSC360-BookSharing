<?php include 'nav/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTrade - Community</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/community.css">
    <link rel="stylesheet" href="css/trending.css">
    <script src="js/headerMenu.js" defer></script>
    <script defer src="js/trendingBooks.js"></script>
</head>

<body>

    <section class="book-container">
        <h2>Trending Books</h2>

        <!-- Recently Selection -->
        <section class="search-bar">
            <select title="recently-filer" id="recently-filer">
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
                <option value="all">All Time</option>
            </select>
        </section>

        <!-- Search Status -->
        <p id="search-status" class="search-status">Searching...</p>

        <!-- Book Listings -->
        <section class="book-grid">
            <p>Loading books...</p>
        </section>

    </section>

    <?php include 'nav/footer.php'; ?>

</body>
</html>