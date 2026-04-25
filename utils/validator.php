<?php

// ===== NAME =====
function validateName($name) {
    return preg_match("/^[a-zA-Z]{2,}$/", $name);
}

// ===== SURNAME =====
function validateSurname($surname) {
    return preg_match("/^[a-zA-Z]{2,}$/", $surname);
}

// ===== USERNAME =====
function validateUsername($username) {
    return preg_match("/^[a-zA-Z0-9_]{3,}$/", $username);
}

// ===== EMAIL =====
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// ===== PASSWORD =====
function validatePassword($password) {
    return strlen($password) >= 6;
}

// ===== PASSWORD MATCH =====
function validatePasswordMatch($password, $confirm) {
    return $password === $confirm;
}
