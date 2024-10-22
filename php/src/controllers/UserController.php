<?php

namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/User.php';
include __DIR__ . '/../middleware.php';
include __DIR__ . '/../models/Job.php';

use config\Database;
use models\User;
use models\Job;

class UserController {
    private $db;
    private $user;

    private $job;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
        $this->job = new Job($db);
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
                $_SESSION['name'] = $this->user->name;
                $_SESSION['role'] = $this->user->role;
                $_SESSION['email'] = $this->user->email;
                if ($_SESSION['role'] === 'jobseeker') {
                    header("Location: /dashboard");
                } else if ($_SESSION['role'] === 'company') {
                    header('Location: /dashboard');
                    exit();
                }
                exit;
            } else {
                $error = "Invalid credentials";
                include __DIR__ . '/../views/Login.php';
            }
        } else {
            include __DIR__ . '/../views/Login.php';
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
            $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $role = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');
    
            if ($this->user->register($name, $email, $password, $role)) {
                session_start();
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['name'] = $this->user->name;
                $_SESSION['role'] = $this->user->role;
                $_SESSION['email'] = $this->user->email;
    
                if ($role === 'jobseeker') {
                    header("Location: /login");
                } else if ($role === 'company') {
                    header("Location: /login");
                }
                exit;
            } else {
                $error = "Registration failed. Please try again.";
                include __DIR__ . '/../views/Register.php';
            }
        } else {
            include __DIR__ . '/../views/Register.php';
        }
    }

    public function jobsHomepage() {
        $offset = (isset($_GET['page'])) ? intval($_GET['page']) * 5 - 5 :0;

        $allJobs = $this->job->getAllJobs(5, $offset);
        $totalJob = $this->job->getTotalJobs();
        $totalPages = intval($totalJob / 5);

        // echo $totalJob;

        include __DIR__ . '/../views/jobsHomepage.php';
    }

    


    public function getAllJobVacancy() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $category = isset($_GET['category']) ? $_GET['category'] : 'All';
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
    
            $jobs = $category === 'All' ? $this->job->getAllJobs($limit, $offset) : $this->job->getJobsByCategory($category);
    
            header('Content-Type: application/json');
            echo json_encode($jobs);
        } else {
            include __DIR__ . '/../views/jobsHomepage.php';
        }
  
    }
}