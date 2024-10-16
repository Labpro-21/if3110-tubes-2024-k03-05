<?php

namespace controllers;

use config\Database;
use models\User;

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function home(): void
    {
        include __DIR__ . '/../views/home.php';
    }

    public function login(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->user->authenticate($email, $password)) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                header("Location: /dashboard");
                exit;
            } else {
                $error = "Invalid credentials";
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function register() {

    }
}