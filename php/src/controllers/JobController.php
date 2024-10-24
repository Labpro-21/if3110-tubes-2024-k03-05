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
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            exit;
        }

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
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
                http_response_code(403);
                echo json_encode(['message' => 'Forbidden']);
                exit;
            }

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
        
        foreach ($jobs as $key => $job) {
            $jobs[$key]['deskripsi'] = preg_replace('/<\/?p>/', '', html_entity_decode($job['deskripsi']));
        }

        header('Content-Type: application/json');
        echo json_encode(['jobs' => $jobs, 'totalPages' => $totalPages, 'currentPage' => $page]);
    }
    

    
    public function detailLowonganJobseeker(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        if (!isset($_GET['lowonganId'])) {
            header("Location: /dashboard");
            exit();
        }

        $id = $_GET['lowonganId'];
        $job = $this->job->getLowonganJobSeekerById($id);
        $attachments = $this->job->getAttachmentsByLowonganId($id);

        // Check if the job is open
        if ($job['is_open'] !== 1) {
            header("Location: /dashboard");
            exit();
        }

        $isAlreadyApply = $this->job->isAlreadyApply($id, $_SESSION['user_id']);
        $totalApplicants = $this->job->getTotalApplicants($id);
        include __DIR__ . '/../views/DetailLowonganJobseeker.php';
    }

    public function detailLowonganGuest(): void
    {
         if (!isset($_GET['lowonganId'])) {
             include __DIR__ . '/../views/404.php';
         }

        $id = $_GET['lowonganId'];
        $job = $this->job->getLowonganGuestById($id);
        $attachments = $this->job->getAttachmentsByLowonganId($id);

        if (!$job) {
            include __DIR__ . '/../views/404.php';
            exit();
        }

        // Check if the job is open
        if ($job['is_open'] !== 1) {
            include __DIR__ . '/../views/404.php';
            exit();
        }

        $totalApplicants = $this->job->getTotalApplicants($id);
        include __DIR__ . '/../views/DetailLowonganGuest.php';
    }

    /**
     * @throws \DateMalformedStringException
     */
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
        $attachments = $this->job->getAttachmentsByLowonganId($lowonganId);

        // Check if the job is owned by the user
        if ($jobData['company_id'] !== $_SESSION['user_id']) {
            header("Location: /dashboard");
            exit();
        }

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
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['lowongan_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing lowongan_id parameter']);
            exit;
        }

        $lowonganId = (int)$data['lowongan_id'];

        // Check if the user is the owner of the job
        $jobData = $this->job->getDetailLowonganById($lowonganId);

        if ($jobData['user_id'] !== $userId) {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden']);
            exit;
        }

        $berhasil = $this->job->closeLowonganCompany($lowonganId);

        if ($berhasil) {
            http_response_code(200);
            echo json_encode(['message' => 'Lowongan closed']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to close lowongan']);
        }
    }
    
    public function deleteLowonganCompany(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            exit;
        }
        
        $userId = (int)$_SESSION['user_id'];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['lowongan_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing lowongan_id parameter']);
            exit;
        }

        $lowonganId = (int)$data['lowongan_id'];

        // Check if the user is the owner of the job
        $jobData = $this->job->getDetailLowonganById($lowonganId);

        if ($jobData['user_id'] !== $userId) {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden']);
            exit;
        }

        $berhasil = $this->job->deleteLowonganCompany($lowonganId);

        if ($berhasil) {
            http_response_code(200);
            echo json_encode(['message' => 'Lowongan deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete lowongan']);
        }
    }

}
