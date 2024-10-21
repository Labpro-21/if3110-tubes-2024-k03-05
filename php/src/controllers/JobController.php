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
