<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit;
}

$userId = $_SESSION["user"]["id"];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

include 'nav/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>BookTrade - Profile</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/profile.css" />
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<div id="header-placeholder"></div>

<?php if (isset($_GET['error'])): ?>
    <div class="error-message">
        <?php
        switch ($_GET['error']) {
            case 'invalid_type':
                echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
                break;
            case 'too_large':
                echo "File size must be under 2MB.";
                break;
            case 'upload_failed':
                echo "Failed to upload profile picture.";
                break;
            case 'db':
                echo "Database update failed.";
                break;
        }
        ?>
    </div>
<?php endif; ?>

<div class="profile-container">
    <div class="profile-left">
        <div class="profile-picture-section">
            <img src="<?php echo $user['profile_image'] ?? 'images/default-profile.png'; ?>" alt="Profile Picture" id="profile-pic-preview">
        </div>

        <form id="profile-form" method="post" action="php/update_profile.php" enctype="multipart/form-data">
            <label for="upload-pic">Change Profile Picture:</label>
            <input type="file" id="upload-pic" name="profile-picture">

            <label for="name">Name:</label>
            <input type="text" id="name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>">

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <div class="profile-right">
        <h2>My Wishlist</h2>
        <div id="wishlist-container">
            <p>No wishlist items yet.</p>
        </div>
    </div>
</div>

<?php include 'nav/footer.php'; ?>

</body>
</html>