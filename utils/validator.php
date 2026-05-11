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



// ===== FULL NAME =====
function validateFullName($name) {
    return preg_match("/^[a-zA-Z\s]{3,50}$/", $name);
}

// ===== ADDRESS =====
function validateAddress($address) {
    return preg_match("/^[a-zA-Z0-9\s,.-]{5,100}$/", $address);
}

// ===== CITY =====
function validateCity($city) {
    return preg_match("/^[a-zA-Z\s]{2,50}$/", $city);
}

// ===== ZIP CODE =====
function validateZip($zip) {
    return preg_match("/^[0-9]{4,10}$/", $zip);
}

// ===== DELIVERY METHOD =====
function validateDeliveryMethod($method) {
    $allowed = ['standard', 'express', 'overnight'];
    return in_array($method, $allowed);
}

// ===== CARD NUMBER =====
function validateCardNumber($card) {
    return preg_match("/^[0-9]{13,19}$/", $card);
}

// ===== EXPIRY DATE (MM/YY) =====
function validateExpiryDate($date) {
    return preg_match("/^(0[1-9]|1[0-2])\/[0-9]{2}$/", $date);
}

// ===== CVV =====
function validateCVV($cvv) {
    return preg_match("/^[0-9]{3,4}$/", $cvv);
}