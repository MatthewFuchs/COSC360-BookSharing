<?php include 'nav/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTrade - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/headerMenu.js" defer></script>
</head>

<body>

    <!-- Intro Section -->
    <div class="intro"> 
        <p>Connecting readers, one book at a time</p>
        <img src="./images/home-intro.png" alt="home-intro" class="introImage" />
    </div>

    <!-- Welcome Section -->
    <section class="welcome">
        <h2>Welcome to BookTrade</h2>
        <p>BookTrade is a community-driven platform where readers can share and exchange books. Whether you're looking to discover your next favorite novel or pass on a book you love, BookTrade makes it easy to connect with other book enthusiasts.</p>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <img src="images/list-book.png" alt="List a book">
                <h3>List a Book</h3>
                <p>Upload details about the books you want to exchange.</p>
            </div>
            <div class="step">
                <img src="images/find-book.png" alt="Find a book">
                <h3>Find a Book</h3>
                <p>Search for books available in your community.</p>
            </div>
            <div class="step">
                <img src="images/trade-book.png" alt="Trade a book">
                <h3>Exchange Books</h3>
                <p>Connect with other users to swap books securely.</p>
            </div>
        </div>
    </section>

    <!-- Popular Listings -->
    <section class="popular-listings">
        <a href="trending.php"><h2>Popular Listings</h2></a>
        <div class="book-list">
            See the top 10 trending books!
        </div>
    </section>

    <!-- Join Community -->
    <section class="community">
        <h2>Join Our Community</h2>
        <p>Engage with fellow book lovers, leave reviews, and participate in discussions.</p>
        <a href="community.php" class="btn">Explore the Community</a>
    </section>

    <?php include 'nav/footer.php'; ?>

</body>
</html>