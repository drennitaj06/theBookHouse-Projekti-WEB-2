<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/constants.php';

// ===== AUTO LOGIN FROM COOKIE =====
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])) {

    $cookieData = json_decode($_COOKIE['remember_user'], true);

    if ($cookieData && isset($cookieData['id'])) {
        $_SESSION['user'] = $cookieData;
    }
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: " . BASE_URL . "pages/login.php");
        exit();
    }
}

function requireUser() {
    requireLogin();
    enforceSessionTimeout();

    if ($_SESSION['user']['role'] !== 'user') {
        header("Location: " . BASE_URL . "pages/admin/dashboard.php");
        exit();
    }
}

function enforceSessionTimeout($timeout = 1800) {
    if (!isset($_SESSION['user'])) {
        return;
    }

    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $inactiveTime = time() - $_SESSION['LAST_ACTIVITY'];

        if ($inactiveTime > $timeout) {
            session_unset();
            session_destroy();

            header("Location: " . BASE_URL . "pages/login.php?timeout=1");
            exit();
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
}

function blockIfLoggedIn() {
    if (!isset($_SESSION['user'])) {
        return;
    }

    $user = $_SESSION['user'];
    $role = $user['role'];
    $username = htmlspecialchars($user['username']);

    ?>
    
    <div class="overlay">
        <div class="overlay-box">
            <h2>You are already logged in</h2>

            <p>
                Logged in as 
                <strong><?= $username ?></strong>
                (<?= strtoupper($role) ?>)
            </p>

            <div class="overlay-actions">
                <a href="<?= BASE_URL ?>auth/logout.php" class="btn logout">Logout</a>

                <?php if ($role === 'admin'): ?>
                    <a href="<?= BASE_URL ?>pages/admin/dashboard.php" class="btn go">Go to Dashboard</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>pages/books.php" class="btn go">Go to Books</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
}