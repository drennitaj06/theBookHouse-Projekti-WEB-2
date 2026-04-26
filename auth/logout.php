<?php
session_start();
session_destroy();

require_once dirname(__DIR__) . '/config/constants.php';

header("Location: " . BASE_URL . "pages/login.php");
exit;