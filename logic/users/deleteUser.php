<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . "/../../data/users.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "Invalid user ID";
    header("Location: " . BASE_URL . "pages/admin/dashboard.php");
    exit;
}

$found = false;

foreach ($users as $index => $user) {
    if ($user['id'] == $id) {
        unset($users[$index]);
        $found = true;
        break;
    }
}

$users = array_values($users);

if (!$found) {
    $_SESSION['error'] = "User not found";
    header("Location: " . BASE_URL . "pages/admin/dashboard.php");
    exit;
}

/* ===== SAVE BACK TO FILE ===== */
$filePath = __DIR__ . "/../../data/users.php";

$fileContent = "<?php\n\n\$users = " . var_export($users, true) . ";\n\n?>";

file_put_contents($filePath, $fileContent);

/* ===== SUCCESS ===== */
$_SESSION['success'] = "User deleted successfully!";

header("Location: " . BASE_URL . "pages/admin/dashboard.php");
exit;