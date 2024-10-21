<?php


namespace controllers;

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

    public function ambilLowongan(): void {
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

        $jobData = $this->job->getLowonganById($lowonganId);
        
        if (!$jobData) {
            header("Location: /dashboard");
            exit();
        }
    
        include __DIR__ ."/../views/EditLowongan.php";
    }

    public function editLowongan(): void {
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $position = $_POST['Position'];
            $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
            $type = $_POST['Type'];
            $workLocation = $_POST['Work'];
            $isOpen = 1; 
    
            if (!empty($position) && !empty($description) && !empty($type) && !empty($workLocation)) {
                $lowonganId = (int)$_GET['lowonganId']; 
                $this->job->editLowongan($lowonganId, $position, $description, $type, $workLocation, $isOpen);
                header('Location: /dashboard');
                exit();
            } else {
                $error = "All fields are required.";
            }
        }
    
        include __DIR__ . '/../views/editLowongan.php';
    }

    
}

