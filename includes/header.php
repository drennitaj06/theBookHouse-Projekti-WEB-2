<?php
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . "/auth/sessionCheck.php";

// Normalize URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPage = basename($uri);

// Helper function
function isActive($page) {
    return strpos($_SERVER['REQUEST_URI'], $page) !== false;
}

// Detect homepage
$isHome = ($currentPage === 'index.php');

$user = $_SESSION['user'] ?? null;
$isAdmin = $user && $user['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <!-- PAGE-SPECIFIC CSS -->
    <?php if (strpos($uri, '/admin/') !== false): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <?php else: ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/pages.css">
    <?php endif; ?>

    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.jpg">

    <title>the BookHouse</title>
</head>

<body>

<?php
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success'], $_SESSION['error']);
?>

<?php if ($success): ?>
    <div class="alert success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error">
        <?= $error ?>
    </div>
<?php endif; ?>

<header>
    <div class="logo">
        <img src="<?= BASE_URL ?>assets/images/logo1.png" alt="Logo">
        <h1>the BookHouse</h1>
    </div>

    <ul class="ulIndex">

        <!-- HOME -->
        <li class="<?= $isHome ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>index.php">HOME</a>
        </li>

        <!-- BOOKS (VISIBLE for guests + users, HIDDEN for admin) -->
        <?php if (!$isAdmin): ?>
            <li class="<?= isActive('books.php') ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>pages/books.php">BOOKS</a>
            </li>
        <?php endif; ?>

        <?php if ($user): ?>

            <?php if ($isAdmin): ?>

                <!-- ADMIN NAV -->
                <li class="<?= isActive('manageBooks.php') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>pages/admin/manageBooks.php">BOOKS</a>
                </li>

                <li class="<?= isActive('dashboard.php') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>pages/admin/dashboard.php">DASHBOARD</a>
                </li>

            <?php else: ?>

                <!-- USER NAV -->
                <li class="<?= isActive('profile.php') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>pages/profile.php">PROFILE</a>
                </li>

            <?php endif; ?>

            <!-- LOGOUT -->
            <li>
                <a href="<?= BASE_URL ?>auth/logout.php">LOGOUT</a>
            </li>

        <?php else: ?>

            <!-- NOT LOGGED IN -->
            <li class="<?= isActive('login.php') ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>pages/login.php">LOGIN</a>
            </li>

        <?php endif; ?>

    </ul>

    <div class="menu-toggle">&#9776;</div>
</header>