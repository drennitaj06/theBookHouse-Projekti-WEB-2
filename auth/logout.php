<?php
session_start();

// destroy session
session_unset();
session_destroy();

// delete cookie
setcookie("remember_user", "", time() - 3600, "/");

require_once dirname(__DIR__) . '/config/constants.php';

header("Location: " . BASE_URL . "pages/login.php");
exit;