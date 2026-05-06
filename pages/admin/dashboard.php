<?php
require_once "../../auth/adminCheck.php";
require_once "../../includes/header.php";

requireAdmin();

/* ===== DATA ===== */
/** @var array $users */
require_once "../../data/users.php";
require_once "../../utils/functions.php";

/* ===== INPUT ===== */
$search = $_GET['q'] ?? '';

/* ===== FILTER ===== */
$filteredUsers = $users;

if (!empty($search)) {
    $filteredUsers = array_filter($filteredUsers, function ($user) use ($search) {
        return stripos($user['username'], $search) !== false ||
               stripos($user['email'], $search) !== false;
    });
}

/* normalize */
$filteredUsers = array_values($filteredUsers);
?>

<div class="page-wrapper">

    <h1 class="page-title">Manage Users</h1>

    <!-- ===== CONTROLS ===== -->
    <form method="GET" class="controls-bar">

        <div class="search-box">
            <input 
                type="text" 
                name="q" 
                placeholder="Search users..." 
                value="<?= htmlspecialchars($search) ?>"
            >
        </div>

        <button type="submit" class="apply-btn">Search</button>

    </form>

    <div class="table-wrapper">
        <table id="table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($filteredUsers)): ?>
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($filteredUsers as $user): ?>
                    <tr>

                        <td><?= $user['id']; ?></td>

                        <td><?= htmlspecialchars($user['username']); ?></td>

                        <td><?= htmlspecialchars($user['email']); ?></td>

                        <td><?= htmlspecialchars($user['role']); ?></td>

                        <td><?= htmlspecialchars($user['created_at'] ?? 'N/A'); ?></td>

                        <td>
                            <?php if (($user['role'] ?? '') !== 'admin'): ?>
                                <a href="../../logic/users/deleteUser.php?id=<?= $user['id'] ?>"
                                   onclick="return confirm('Delete this user?')"
                                   class="delete-link">
                                    Delete
                                </a>
                            <?php else: ?>
                                <span style="opacity: 0.5;">Protected</span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
    </div>

</div>

<?php require_once "../../includes/footer.php"; ?>