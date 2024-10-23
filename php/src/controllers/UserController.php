<?php

namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/User.php';
include __DIR__ . '/../middleware.php';
include __DIR__ . '/../models/Job.php';

use config\Database;
use Exception;
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
        include __DIR__ . '/../views/LandingPage.php';
    }

    public function login(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Read the raw POST data
            $json = file_get_contents('php://input');

            // Decode the JSON data into a PHP array
            $data = json_decode($json, true);

            // Check if the data was decoded successfully
            if ($data === null) {
                // Handle JSON decode error
                http_response_code(400);
                echo json_encode(['message' => 'Invalid JSON']);
                exit;
            }

            $email = $data['email'];
            $password = $data['password'];

            if ($this->user->authenticate($email, $password)) {

                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['name'] = $this->user->name;
                $_SESSION['email'] = $this->user->email;
                $_SESSION['role'] = $this->user->role;

                http_response_code(200);
                echo json_encode(['message' => 'Login successful']);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Credential incorrect']);
            }
            exit;
        } else {
            // Redirect to dashboard if user is already logged in
            if (isset($_SESSION['user_id'])) {
                header("Location: /dashboard");
                exit;
            }

            include __DIR__ . '/../views/Login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }

    /**
     * @throws Exception
     */
    public function register(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Read the raw POST data
            $json = file_get_contents('php://input');

            // Decode the JSON data into a PHP array
            $data = json_decode($json, true);

            // Check if the data was decoded successfully
            if ($data === null) {
                // Handle JSON decode error
                http_response_code(400);
                echo json_encode(['message' => 'Invalid JSON']);
                exit;
            }

            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['type'];

            if ($role !== 'jobseeker' && $role !== 'company') {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid role']);
                exit;
            }

            if ($this->user->isEmailExists($email)) {
                http_response_code(400);
                echo json_encode(['message' => 'Email already exists']);
                exit;
            }

            if ($this->user->register($name, $email, $password, $role)) {
                http_response_code(201);
                echo json_encode(['message' => 'User registered successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to register user']);
            }
            exit;
        } else {
            // Redirect to dashboard if user is already logged in
            if (isset($_SESSION['user_id'])) {
                header("Location: /dashboard");
                exit;
            }

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

