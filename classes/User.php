<?php

class User {
    protected $id;
    protected $name;
    protected $surname;
    protected $username;
    protected $email;
    protected $password;
    protected $phone;
    protected $address;
    protected $role;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->surname = $data['surname'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->role = $data['role'];
    }

    // Getters
    public function getId() { return $this->id; }
    public function getFullName() { return $this->name . ' ' . $this->surname; }
    public function getUsername() { return $this->username; }
    public function getRole() { return $this->role; }

    // Auth
    public function checkPassword($password) {
        return $this->password === $password;
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    // Static login helper
    public static function login($users, $username, $password) {
        foreach ($users as $u) {
            if ($u['username'] === $username && $u['password'] === $password) {
                return new User($u);
            }
        }
        return null;
    }
}