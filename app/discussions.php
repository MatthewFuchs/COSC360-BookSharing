<?php
require_once "php/config.php";

$searchQuery = $_GET['search'] ?? '';
$currentPage = max((int)($_GET['page'] ?? 1), 1);
$limit = 10;
$offset = ($currentPage - 1) * $limit;

$searchParam = '%' . $searchQuery . '%';

// Count total discussions
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total 
    FROM discussions d 
    JOIN users u ON d.user_id = u.id 
    WHERE d.title LIKE ?
");
$countStmt->bind_param("s", $searchParam);
$countStmt->execute();
$countResult = $countStmt->get_result();
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Fetch paginated discussions
$stmt = $conn->prepare("
    SELECT d.id, d.title, d.created_at, u.username 
    FROM discussions d
    JOIN users u ON d.user_id = u.id
    WHERE d.title LIKE ?
    ORDER BY d.created_at DESC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("sii", $searchParam, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
$discussions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Discussions | BookTrade</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/discussions.css" />
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="discussions-container">
    <h1>Community Discussions</h1>

    <!-- Search -->
    <form method="get" class="search-bar" style="margin-bottom: 1em;">
        <input type="text" name="search" placeholder="🔍 Search discussions..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
        <button type="button" id="create-discussion">Create Discussion</button>
    </form>

    <!-- Discussion List -->
    <div class="discussion-list">
        <?php if (empty($discussions)): ?>
            <p>No discussions found.</p>
        <?php else: ?>
            <?php foreach ($discussions as $discussion): ?>
                <div class="discussion" onclick="window.location.href='discussion.php?id=<?= $discussion['id']; ?>'">
                    <p class="discussion-title"><?= htmlspecialchars($discussion['title']); ?></p>
                    <p class="discussion-info">
                        Started by <strong><?= htmlspecialchars($discussion['username']); ?></strong> • 
                        <?= date('F j, Y', strtotime($discussion['created_at'])); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($totalPages > 1): ?>
            <?php if ($currentPage > 1): ?>
                <a href="?search=<?= urlencode($searchQuery); ?>&page=<?= $currentPage - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($searchQuery); ?>&page=<?= $i ?>" class="<?= $i == $currentPage ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?search=<?= urlencode($searchQuery); ?>&page=<?= $currentPage + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'nav/footer.php'; ?>

<script>
    document.getElementById("create-discussion").addEventListener("click", () => {
        window.location.href = "new-discussion.php";
    });
</script>

</body>
</html>