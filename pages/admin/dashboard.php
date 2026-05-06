<?php
require_once "../../auth/adminCheck.php";
require_once "../../includes/header.php";

requireAdmin();

/* ===== DATA ===== */
/** @var array $users */
require_once "../../data/users.php"; // assuming this exists
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

<link rel="stylesheet" href="../../assets/css/admin.css">

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
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($filteredUsers)): ?>
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($filteredUsers as $user): ?>
                    <tr>

                        <td><?= $user['id']; ?></td>

                        <td>
                            <?= htmlspecialchars($user['username']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['email']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['role']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['created_at'] ?? 'N/A'); ?>
                        </td>

                        <!-- NOT FUNCTIONAL YET -->
                        <td>
                            <a href="#" class="delete-link">Delete</a>
                        </td>

                        <td>
                            <a href="#" class="edit-link">Edit</a>
                        </td>

                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
    </div>

</div>

<?php require_once "../../includes/footer.php"; ?>