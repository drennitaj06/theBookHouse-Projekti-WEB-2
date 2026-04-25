<?php

require_once __DIR__ . '/sessionCheck.php';

/**
 * Require admin role
 */
function requireAdmin() {
    requireLogin();
    enforceSessionTimeout();

    if ($_SESSION['user']['role'] !== 'admin') {
        // Optional: redirect based on role
        header("Location: " . BASE_URL . "pages/books.php");
        exit();
    }
}