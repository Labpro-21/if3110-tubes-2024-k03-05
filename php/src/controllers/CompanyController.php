<?php

namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Job.php';

use config\Database;
use models\Job;

class CompanyController {
    private $conn;
    private $job;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->job = new Job($this->conn);
    }

    public function getCompanyDetails($companyId) {
        $query = "SELECT * FROM company_detail WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $companyId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function tambahLowongan(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $position = $_POST['Position'];
            $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
            $type = $_POST['Type'] ;
            $workLocation = $_POST['Work'];
            $isOpen = 1;

            $companyId = $_SESSION['user_id'];

            if (!empty($position) && !empty($description) && !empty($type) && !empty($workLocation)) {
                $this->job->addLowongan($companyId, $position, $description, $type, $workLocation, $isOpen);
                header('Location: /dashboard');
                exit();
            } else {
                echo "Failed to add job vacancy";
            }
        }
        include __DIR__ . '/../views/TambahLowongan.php';
    }

    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }

        $jobs = $this->job->getLowonganByCompanyId($_SESSION['user_id']);
        $companyDetails = $this->getCompanyDetails($_SESSION['user_id']);

        $details = [
            'name' => $_SESSION['name'],
            'about' => $companyDetails['about'],
            'location' => $companyDetails['lokasi'],
        ];

        include __DIR__ . '/../views/CompanyHome.php';
    }
}
