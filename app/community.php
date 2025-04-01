<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTrade - Community</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/community.css">
    <script src="js/headerMenu.js" defer></script>
    <script defer src="js/community.js"></script>
</head>
<body>

    <?php include 'nav/header.php'; ?>

    <section class="community-container">
        <h2>Community Discussions</h2>

        <!-- Search Discussions -->
        <div class="search-bar">
            <input type="text" id="search-discussions" placeholder="Search discussions...">
            <button id="search-btn">Search</button>
        </div>

        <!-- Discussion List -->
        <div class="discussion-list">
            <h3>Recent Discussions</h3>
            <ul id="discussion-threads">
                <!-- Discussions will be dynamically loaded here -->
            </ul>
            <button id="view-more">View More</button>
        </div>

        <!-- Recent Reviews -->
        <div class="review-section">
            <h3>Recent Book Reviews</h3>
            <ul id="recent-reviews">
                <!-- Reviews will be dynamically loaded here -->
            </ul>
        </div>

        <!-- Start New Discussion -->
        <div class="new-discussion">
            <button id="start-discussion">Start a Discussion</button>
        </div>
    </section>

    <?php include 'nav/footer.php'; ?>

</body>
</html>