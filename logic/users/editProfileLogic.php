<?php
session_start();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once __DIR__ . "/../../data/users.php";
require_once __DIR__ . "/../../utils/validator.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "pages/profile.php");
    exit;
}

$id = $_POST['id'] ?? null;

$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);

$errors = [];

if (!validateName($name)) {
    $errors[] = "Invalid name";
}

if (!validateSurname($surname)) {
    $errors[] = "Invalid surname";
}

if (!empty($errors)) {
    $_SESSION['error'] = implode("<br>", $errors);
    header("Location: " . BASE_URL . "pages/editProfile.php");
    exit;
}

foreach ($users as &$user) {
    if ($user['id'] == $id) {
        $user['name'] = $name;
        $user['surname'] = $surname;
        $user['phone'] = $phone;
        $user['address'] = $address;

        $_SESSION['user']['name'] = $name;

        break;
    }
}

$filePath = __DIR__ . "/../../data/users.php";
file_put_contents($filePath, "<?php\n\n\$users = " . var_export($users, true) . ";\n\n?>");

$_SESSION['success'] = "Profile updated successfully!";

header("Location: " . BASE_URL . "pages/profile.php");
exit;