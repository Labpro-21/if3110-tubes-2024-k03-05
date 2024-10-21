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

    public function getJobs() {
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
}
