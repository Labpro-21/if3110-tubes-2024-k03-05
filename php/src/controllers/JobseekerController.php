<?php

namespace controllers;

use models\Job;
use config\Database;

class JobseekerController
{
    private $conn;
    private $job;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->job = new Job($this->conn);
    }

    public function getUserDetails($userId) {
        $query = "SELECT * FROM user WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        return $stmt->fetch();
    }


    public function dashboard(): void
    {
        // Check if the user is logged in and has the 'jobseeker' role
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];

        $userDetails = $this->getUserDetails($userId);
        $details = [
            'name' => $_SESSION['name'],
            'email' => $userDetails['email'],
            'role' => $userDetails['role'],
        ];
        
    
        // Include the view
        include __DIR__ . '/../views/jobsHomepage.php';
    }



    public function lamaran(): void
    {
        include __DIR__ . '/../views/LamaranJobseeker.php';
    }
}