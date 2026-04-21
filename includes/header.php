<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Normalize URI (remove query params)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Helper function (kept similar to yours)
function isActive($path) {
    global $uri;
    return strpos($uri, $path) !== false;
}

// Detect homepage properly
$isHome = ($uri === '/' || $uri === '/index.php');
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
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- PAGE-SPECIFIC CSS -->
    <?php if (strpos($uri, '/admin/') !== false): ?>
        <link rel="stylesheet" href="assets/css/admin.css">
    <?php else: ?>
        <link rel="stylesheet" href="assets/css/pages.css">
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" href="assets/images/logo.jpg">

    <title>the BookHouse</title>
</head>

<body>

<header>
    <div class="logo">
        <img src="assets/images/logo1.png" alt="Logo">
        <h1>the BookHouse</h1>
    </div>

    <ul class="ulIndex">
        <li class="<?= $isHome ? 'active' : '' ?>">
            <a href="/index.php">HOME</a>
        </li>

        <li class="<?= isActive('/pages/books.php') ? 'active' : '' ?>">
            <a href="/pages/books.php">BOOKS</a>
        </li>

        <?php if (isset($_SESSION['user'])): ?>

            <li class="<?= isActive('/pages/profile.php') ? 'active' : '' ?>">
                <a href="/pages/profile.php">PROFILE</a>
            </li>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <li class="<?= isActive('/pages/admin/') ? 'active' : '' ?>">
                    <a href="/pages/admin/dashboard.php">ADMIN</a>
                </li>
            <?php endif; ?>

            <li>
                <a href="/auth/logout.php">LOGOUT</a>
            </li>

        <?php else: ?>

            <li class="<?= (isActive('/pages/login.php') || isActive('/pages/register.php')) ? 'active' : '' ?>">
                <a href="/pages/login.php">LOGIN</a>
            </li>

        <?php endif; ?>
    </ul>

    <div class="menu-toggle">&#9776;</div> 
</header>