<?php
session_start();

require_once dirname(__DIR__) . '/config/constants.php';
require_once __DIR__ . '/../data/users.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Admin.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    foreach ($users as $u) {

        // check username first
        if ($u['username'] !== $username) {
            continue;
        }

        // TEMP: allow plain passwords for dummy data
        if (password_verify($password, $u['password']) || $u['password'] === $password) {

            // ===== ROLE CHECK =====
            if ($u['role'] === 'admin') {

                $admin = new Admin($u);

                $_SESSION['user'] = [
                    'id' => $admin->getId(),
                    'name' => $admin->getFullName(),
                    'username' => $admin->getUsername(),
                    'role' => 'admin'
                ];

                $_SESSION['success'] = "Welcome back, Admin!";
                header("Location: " . BASE_URL . "pages/admin/dashboard.php");
                exit;

            } else {

                $user = new User($u);

                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'name' => $user->getFullName(),
                    'username' => $user->getUsername(),
                    'role' => 'user'
                ];

                $_SESSION['success'] = "Welcome back!";
                header("Location: " . BASE_URL . "pages/books.php");
                exit;
            }
        }

        // username matched but password wrong → break early
        break;
    }

    // ===== GENERIC ERROR =====
    $_SESSION['error'] = "Invalid username or password";
    header("Location: " . BASE_URL . "pages/login.php");
    exit;
}