<?php
session_start();
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

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <title>the BookHouse</title>
</head>

<body>

<header>
    <div class="logo">
        <img src="/assets/images/logo1.png" alt="Logo">
        <h1>the BookHouse</h1>
    </div>

    <ul class="ulIndex">
        <li><a href="/index.php">HOME</a></li>
        <li><a href="/pages/books.php">BOOKS</a></li>

        <?php if(isset($_SESSION['user'])): ?>
            <li><a href="/pages/profile.php">PROFILE</a></li>

            <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <li><a href="/pages/admin/dashboard.php">ADMIN</a></li>
            <?php endif; ?>

            <li><a href="/auth/logout.php">LOGOUT</a></li>

        <?php else: ?>
            <li><a href="/pages/login.php">LOGIN</a></li>
        <?php endif; ?>
    </ul>
</header>