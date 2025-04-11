<?php include 'nav/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us | BookTrade</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/contact.css" />
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<div class="contact-container">
    <h1>Contact Us</h1>

    <p>If you have questions, feedback, or suggestions, feel free to reach out! We're here to make BookTrade better for everyone.</p>

    <form method="post" action="php/send_contact.php" class="contact-form">
        <label for="name">Your Name</label>
        <input type="text" name="name" id="name" required />

        <label for="email">Your Email</label>
        <input type="email" name="email" id="email" required />

        <label for="message">Your Message</label>
        <textarea name="message" id="message" rows="6" required></textarea>

        <button type="submit">Send Message</button>
    </form>
    <?php if (isset($_GET['status'])): ?>
    <div class="contact-feedback">
        <?php
        if ($_GET['status'] === 'success') {
            echo "<p class='success'>Thanks for your message! We'll get back to you soon.</p>";
        } elseif ($_GET['status'] === 'fail') {
            echo "<p class='error'>Oops! Something went wrong. Please try again.</p>";
        } elseif ($_GET['status'] === 'error') {
            echo "<p class='error'>Please fill in all fields correctly.</p>";
        }
        ?>
    </div>
<?php endif; ?>
</div>

<?php include 'nav/footer.php'; ?>
</body>
</html>