<?php
require_once "php/config.php";
session_start();

$discussionId = $_GET['id'] ?? null;
if (!$discussionId) {
    header("Location: discussions.php");
    exit;
}

// Fetch discussion data
$stmt = $conn->prepare("SELECT d.title, d.content, d.created_at, u.username 
                        FROM discussions d 
                        JOIN users u ON d.user_id = u.id 
                        WHERE d.id = ?");
$stmt->bind_param("i", $discussionId);
$stmt->execute();
$result = $stmt->get_result();
$discussion = $result->fetch_assoc();

if (!$discussion) {
    echo "<p>Discussion not found.</p>";
    exit;
}

// Fetch replies
$replyStmt = $conn->prepare("SELECT r.content, r.created_at, u.username 
                             FROM replies r 
                             JOIN users u ON r.user_id = u.id 
                             WHERE r.discussion_id = ? 
                             ORDER BY r.created_at ASC");
$replyStmt->bind_param("i", $discussionId);
$replyStmt->execute();
$replies = $replyStmt->get_result()->fetch_all(MYSQLI_ASSOC);

$isLoggedIn = isset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($discussion['title']); ?> | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/discussion.css">
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="discussion-container">
    <h1><?php echo htmlspecialchars($discussion['title']); ?></h1>

    <div class="original-post">
        <p><?php echo nl2br(htmlspecialchars($discussion['content'])); ?></p>
        <span class="post-author">
            Posted by <strong><?php echo htmlspecialchars($discussion['username']); ?></strong>
            on <?php echo date("F j, Y, g:i a", strtotime($discussion['created_at'])); ?>
        </span>
    </div>

    <?php if ($isLoggedIn): ?>
        <div class="reply-section">
            <form method="post" action="php/post_reply.php">
                <textarea name="reply" placeholder="Write a reply..." required></textarea>
                <input type="hidden" name="discussion_id" value="<?php echo $discussionId; ?>">
                <button type="submit">Post Reply</button>
            </form>
        </div>
    <?php else: ?>
        <div class="reply-section">
            <p><em>You must be <a href="login.php">logged in</a> to reply.</em></p>
        </div>
    <?php endif; ?>

    <div class="replies-container">
    <h2>Replies</h2>
    <ul id="reply-list"></ul>
    </div>
</div>

<?php include 'nav/footer.php'; ?>

<script>
    const discussionId = <?= json_encode($discussionId); ?>;

    function fetchReplies() {
        fetch(`php/get_replies.php?discussion_id=${discussionId}`)
            .then(res => res.json())
            .then(data => {
                const replyList = document.getElementById("reply-list");
                replyList.innerHTML = "";

                if (data.length === 0) {
                    replyList.innerHTML = "<p>No replies yet. Be the first to respond!</p>";
                    return;
                }

                data.forEach(reply => {
                    const li = document.createElement("li");
                    li.className = "reply";
                    li.innerHTML = `
                        <p>${reply.content}</p>
                        <span class="reply-author">
                            Posted by <strong>${reply.username}</strong>
                            on ${new Date(reply.created_at).toLocaleString()}
                        </span>
                    `;
                    replyList.appendChild(li);
                });
            });
    }

    // Initial load
    fetchReplies();

    // Poll every 10 seconds
    setInterval(fetchReplies, 10000);
</script>

</body>
</html>