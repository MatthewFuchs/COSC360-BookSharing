<?php include 'nav/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookTrade - Login / Sign Up</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/login.css" />
    <script src="js/headerMenu.js" defer></script>
    <script defer src="js/login.js"></script>
</head>
<body>

    <!-- Login & Signup Section -->
    <div class="auth-wrapper">
        <!-- Login Section -->
        <div class="auth-section">
            <h2>Login</h2>
            <form id="login-form" action="php/login.php" method="post">
                <label for="login-username">Username</label>
                <input type="text" id="login-username" name="login-username" placeholder="Enter your username" required>
                
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="login-password" placeholder="Enter your password" required>
                
                <p class="or">Or continue with</p>
                <div class="social-login">
                    <button type="button" class="facebook"></button>
                    <button type="button" class="google"></button>
                    <button type="button" class="apple"></button>
                </div>

                <input type="submit" class="auth-btn" value="Login">
            </form>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Sign Up Section -->
        <div class="auth-section">
            <h2>Sign Up</h2>
            <form id="signup-form" action="php/signup.php" method="post">
                <label for="signup-email">Email</label>
                <input type="email" id="signup-email" name="signup-email" placeholder="Enter your email" required>
                
                <label for="signup-username">Username</label>
                <input type="text" id="signup-username" name="signup-username" placeholder="Choose a username" required>
                
                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="signup-password" placeholder="Enter your password" required>
                
                <label for="signup-confirm-password">Confirm Password</label>
                <input type="password" id="signup-confirm-password" name="signup-confirm-password" placeholder="Confirm your password" required>
                
                <p class="or">Or continue with</p>
                <div class="social-login">
                    <button type="button" class="facebook"></button>
                    <button type="button" class="google"></button>
                    <button type="button" class="apple"></button>
                </div>

                <input type="submit" class="auth-btn" value="Sign Up">
            </form>
        </div>
    </div>

    <?php include 'nav/footer.php'; ?>

</body>
</html>