<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . '/../../data/users.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "pages/profile.php");
    exit;
}

$sessionUser = $_SESSION['user'] ?? null;

if (!$sessionUser) {
    $_SESSION['error'] = "You must be logged in.";
    header("Location: " . BASE_URL . "pages/login.php");
    exit;
}

/* ===== INPUT ===== */
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

$errors = [];

/* ===== VALIDATION ===== */
if (strlen($newPassword) < 6) {
    $errors[] = "New password must be at least 6 characters.";
}

if ($newPassword !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

/* ===== FIND USER ===== */
$userIndex = null;

foreach ($users as $index => $user) {
    if ($user['id'] == $sessionUser['id']) {
        $userIndex = $index;

        // verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            $errors[] = "Current password is incorrect.";
        }

        break;
    }
}

/* ===== ERROR HANDLING ===== */
if (!empty($errors)) {
    $_SESSION['error'] = implode("<br>", $errors);
    header("Location: " . BASE_URL . "pages/changePassword.php");
    exit;
}

/* ===== UPDATE PASSWORD ===== */
$users[$userIndex]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

/* ===== SAVE TO FILE ===== */
$filePath = __DIR__ . '/../../data/users.php';

file_put_contents(
    $filePath,
    "<?php\n\n\$users = " . var_export($users, true) . ";\n\n?>"
);

/* ===== SUCCESS ===== */
$_SESSION['success'] = "Password changed successfully!";

header("Location: " . BASE_URL . "pages/profile.php");
exit;