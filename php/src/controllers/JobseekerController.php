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

    public function dashboard(): void
    {
        // Check if the user is logged in and has the 'jobseeker' role
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }
    
        // Get the category and page from the query parameters
        $category = $_GET['category'] ?? 'all';
        $categoryLoc = $_GET['categoryLoc'] ?? 'all';
        $categorySort = $_GET['categorySort'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5; // Number of jobs per page
    
        // Calculate the offset for the database query
        $offset = ($page - 1) * $limit;

        $jobs = $this->job->getJobsByCategory($category, $categoryLoc, $categorySort);

        // Fetch jobs by category with pagination
        $totalJob = count($jobs);
        $totalPages = intval($totalJob / 5);
        if ($totalJob % 5 > 0) {
            $totalPages++;
        }

        $parsedJobs = array_slice($jobs, $offset, 5);

        // Prepare details for the view
        
    
        // Include the view
        include __DIR__ . '/../views/jobsHomepage.php';
    }
}