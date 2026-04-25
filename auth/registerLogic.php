<?php
session_start();

require_once dirname(__DIR__) . '/config/constants.php';
require_once __DIR__ . "/../data/users.php";
require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../utils/validator.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmedPassword = $_POST['confirmed_password'];
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    $errors = [];

    // ===== VALIDATION =====
    if (!validateName($name)) {
        $errors['name'] = "Invalid name (letters only, min 2)";
    }

    if (!validateSurname($surname)) {
        $errors['surname'] = "Invalid surname (letters only, min 2)";
    }

    if (!validateUsername($username)) {
        $errors['username'] = "Invalid username (min 3, letters/numbers/_)";
    }

    if (!validateEmail($email)) {
        $errors['email'] = "Invalid email format";
    }

    if (!validatePassword($password)) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if (!validatePasswordMatch($password, $confirmedPassword)) {
        $errors['confirmed_password'] = "Passwords do not match";
    }

    // ===== IF ERRORS =====
    if (!empty($errors)) {

        $errorMessage = implode("<br>", array_values($errors));

        $_SESSION['error'] = $errorMessage;
        $_SESSION['old'] = $_POST;

        header("Location: " . BASE_URL . "pages/register.php");
        exit;
    }
}