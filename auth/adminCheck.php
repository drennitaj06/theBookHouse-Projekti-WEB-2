<?php

require_once __DIR__ . '/sessionCheck.php';


function requireAdmin() {
    requireLogin();
    enforceSessionTimeout();

    if ($_SESSION['user']['role'] !== 'admin') {
        header("Location: " . BASE_URL . "pages/books.php");
        exit();
    }
}