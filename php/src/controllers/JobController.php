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
}
