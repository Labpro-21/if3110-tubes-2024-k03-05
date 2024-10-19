<?php

namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/User.php';
include __DIR__ . '/../middleware.php';

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
        echo "Welcome to Landing Page";
    }

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->user->authenticate($email, $password)) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['role'] = $this->user->role;
                $_SESSION['email'] = $this->user->email;
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
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            if ($this->user->register($username, $email, $password, $role)) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['role'] = $this->user->role;
                $_SESSION['email'] = $this->user->email;
                header("Location: /dashboard");
                exit;
            } else {
                $error = "Invalid credentials";
                include __DIR__ . '/../views/register.php';
            }
        } else {
            include __DIR__ . '/../views/register.php';
        }
    }
}