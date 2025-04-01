<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        $userId = $_SESSION['user']['id'];

        $stmt = $conn->prepare("INSERT INTO discussions (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $userId, $title, $content);

        if ($stmt->execute()) {
            $newId = $conn->insert_id;
            header("Location: discussion.php?id=" . $newId);
            exit;
        } else {
            $error = "Failed to create discussion. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start a New Discussion | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/new-discussion.css">
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="discussion-container">
    <h1>Start a New Discussion</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="new-discussion.php">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required placeholder="Enter discussion title">

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="6" required placeholder="Write your discussion content..."></textarea>

        <button type="submit">Create Discussion</button>
    </form>
</div>

<?php include 'nav/footer.php'; ?>

</body>
</html>