<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, username, email, full_name, location, role, created_at FROM users ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$discussionQuery = $conn->prepare("
    SELECT d.id, d.title, d.created_at, u.username
    FROM discussions d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.created_at DESC
");
$discussionQuery->execute();
$discussionResult = $discussionQuery->get_result();
$discussions = $discussionResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/headerMenu.js" defer></script>
    <script src="js/admin.js" defer></script>
</head>
<body>

<?php include "nav/header.php"; ?>

<div class="admin-dashboard">
    <aside class="admin-sidebar">
        <div class="admin-profile">
            <img src="images/default-profile.png" alt="Admin Profile" class="admin-avatar">
            <h2><?= htmlspecialchars($_SESSION['user']['username']) ?></h2>
            <p><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
        </div>
        <nav class="admin-nav">
            <button class="nav-btn active" onclick="showSection('users')">User Database</button>
            <button class="nav-btn" onclick="showSection('discussions')">Moderate Discussions</button>
            <a href="php/logout.php" class="logout-btn">Sign Out</a>
        </nav>
    </aside>

    <main class="admin-content">
        <section id="users-section" class="dashboard-section active">
            <h2>Users <span class="badge"><?= count($users) ?> users</span></h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Username</th><th>Email</th><th>Location</th><th>Role</th><th>Joined</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['location'] ?? '—') ?></td>
                        <td><span class="role-tag <?= $user['role'] ?>"><?= $user['role'] ?></span></td>
                        <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                        <td>
                        <button class="edit-btn"
                            onclick='openEditModal(<?= $user["id"] ?>, 
                            <?= json_encode($user["full_name"]) ?>, 
                            <?= json_encode($user["email"]) ?>, 
                            <?= json_encode($user["location"]) ?>, 
                            <?= json_encode($user["role"]) ?>)'
                        >✏️</button>
                        <button class="delete-btn" data-id="<?= $user['id'] ?>">🗑️</button>
                        <?php $isDisabled = $user['status'] === 'disabled'; ?>
                        <button class="toggle-status-btn" 
                            data-id="<?= $user['id'] ?>" 
                            data-status="<?= $isDisabled ? 'enable' : 'disable' ?>">
                            <?= $isDisabled ? 'Enable' : 'Disable' ?>
                        </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="discussions-section" class="dashboard-section">
            <h2>Discussion Moderation <span class="badge"><?= count($discussions) ?> discussions</span></h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($discussions as $d): ?>
                    <tr>
                        <td><?= $d['id'] ?></td>
                        <td><?= htmlspecialchars($d['title']) ?></td>
                        <td><?= htmlspecialchars($d['username']) ?></td>
                        <td><?= date('Y-m-d', strtotime($d['created_at'])) ?></td>
                        <td>
                            <button class="delete-discussion-btn" data-id="<?= $d['id'] ?>">🗑️</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h3>Edit User</h3>
            <form id="editUserForm" method="post" action="php/admin_users.php">
                <input type="hidden" name="user_id" id="edit-user-id">
                <label for="edit-full-name">Full Name:</label>
                <input type="text" name="full_name" id="edit-full-name" required>
                <label for="edit-email">Email:</label>
                <input type="email" name="email" id="edit-email" required>
                <label for="edit-location">Location:</label>
                <input type="text" name="location" id="edit-location">
                <div id="edit-role-group">
                    <label for="edit-role">Role:</label>
                    <select name="role" id="edit-role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include "nav/footer.php"; ?>
</body>
</html>