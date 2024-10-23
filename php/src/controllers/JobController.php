<?php

namespace controllers;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Job.php';

use DateTime;

use config\Database;
use models\Job;

class JobController {
    private $db;
    private $job;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->job = new Job($this->db);
    }

    public function getJobs(): void
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $jobs = $this->job->getJobs($limit, $offset);

        header('Content-Type: application/json');
        echo json_encode($jobs);
    }

    public function getCategoryJobs(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $category = isset($_GET['limit']) ? $_GET['Category'] : "ALL";

            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $jobs = $this->job->getJobsByCategory($category);

            header('Content-Type: application/json');
            echo json_encode($jobs);
        }
    }

    

    public function seeLamaran(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'company') {
            header("Location: /login");
            exit();
        }

        $status = $_GET['status'] ?? 'all';

        $jobs = $this->job->getJobsByUserId($_SESSION['user_id'], $status);

        if (count($jobs) > 0) {
            include __DIR__ . '/../views/RiwayatNonEmpty.php';
        } else {
            include __DIR__ . '/../views/RiwayatEmpty.php';
        }
    }

    public function getFilteredJobs(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            exit;
        }

        $category = $_GET['category'] ?? 'all';
        $categoryLoc = $_GET['categoryLoc'] ?? 'all';
        $categorySort = $_GET['categorySort'] ?? '';
        $searchTerm = $_GET['search'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $jobs = $this->job->getJobsByCategory($category, $categoryLoc, $categorySort, $searchTerm);
        $totalJobs = count($jobs);
        $totalPages = ceil($totalJobs / $limit);

        $jobs = array_slice($jobs, $offset, $limit);

        header('Content-Type: application/json');
        echo json_encode(['jobs' => $jobs, 'totalPages' => $totalPages, 'currentPage' => $page]);
    }
    
    public function detailLowonganJobseeker(): void
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing id parameter']);
            exit;
        }

        $id = $_GET['id'];

        $job = $this->job->getLowonganById($id);

        if (!$job) {
            http_response_code(404);
            echo json_encode(['message' => 'Job not found']);
            exit;
        }

        $totalApplicants = $this->job->getTotalApplicants($id);

        include __DIR__ . '/../views/DetailLowonganJobseeker.php';
    }

    public function detailLowonganCompany(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
    
        if (isset($_GET['lowonganId'])) {
            $lowonganId = (int)$_GET['lowonganId']; 
        } else {
            header("Location: /dashboard");
            exit();
        }

        $jobData = $this->job->getDetailLowonganById($lowonganId);

        
        if (!$jobData) {
            header("Location: /dashboard");
            exit();
        }
        $daysAgo = (new DateTime())->diff(new DateTime($jobData['created_at']))->days;
        $totalApplicants = $this->job->getTotalApplicants($lowonganId);
        $applicants = $this->job->getApplicantsByLowonganId($lowonganId);
    
        include __DIR__ . '/../views/DetailLowonganCompany.php';
    }

    public function closeLowonganCompany(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
        
        $userId = (int)$_SESSION['user_id'];

        if (isset($_GET['lowongan_id'])) {
            $lowonganId = (int)$_GET['lowongan_id']; 
        } else {
            header("Location: /dashboard");
            exit();
        }

        $berhasil = $this->job->closeLowonganCompany($lowonganId);

        if ($berhasil) {
            header("Location: /profileCompany?user_id=$userId");
            exit();
        } else {
            header("Location: /dashboard?error=failed_to_close");
            exit();
        }
    }
    
    public function deleteLowonganCompany(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
        
        $userId = (int)$_SESSION['user_id'];

        if (isset($_GET['lowongan_id'])) {
            $lowonganId = (int)$_GET['lowongan_id']; 
        } else {
            header("Location: /dashboard");
            exit();
        }

        $berhasil = $this->job->deleteLowonganCompany($lowonganId);

        if ($berhasil) {
            header("Location: /profileCompany?user_id=$userId>");
            exit();
        } else {
            header("Location: /dashboard?error=failed_to_delete");
            exit();
        }
    }

}
