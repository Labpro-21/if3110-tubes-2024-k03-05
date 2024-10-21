<?php

namespace controllers;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Job.php';

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

    public function seeLamaran(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'company') {
            header("Location: /login");
            exit();
        }

        $status = isset($_GET['status']) ? $_GET['status'] : 'all';

        $jobs = $this->job->getJobsByUserId($_SESSION['user_id'], $status);

        if (count($jobs) > 0) {
            include __DIR__ . '/../views/RiwayatNonEmpty.php';
        } else {
            include __DIR__ . '/../views/RiwayatEmpty.php';
        }
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

}
