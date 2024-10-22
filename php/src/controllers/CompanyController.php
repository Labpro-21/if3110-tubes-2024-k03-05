<?php


namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Job.php';

use config\Database;
use models\Job;
use models\Company;

class CompanyController {
    private $conn;
    private $job;
    private $company;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); 
        $this->job = new Job($this->conn); 
        $this->company = new Company($this->conn); 
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


    public function ambilLowongan(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
    
        if (isset($_GET['lowongan_id'])) {
            $lowonganId = (int)$_GET['lowongan_id']; 
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
            $description = $_POST['description'];
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

    public function ambilProfile(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
    
        if (isset($_SESSION['user_id'])) {
            $userId = (int)$_SESSION['user_id']; 
        } else {
            echo'masuk';
            header("Location: /dashboard");
            exit();
        }

        $companyData = $this->company->getProfileById($userId);
        
        if (!$companyData) {
            header("Location: /dashboard");
            exit();
        }
    
        include __DIR__ ."/../views/EditProfileCompany.php";
    }

    public function editProfile(): void {
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $about = $_POST['about'];
            $email = $_POST['email'];
            $location = $_POST['location'];
    
            if (!empty($name) && !empty($about) && !empty($email) && !empty($location)) {
                $userId = (int)$_SESSION['user_id']; 
                $this->company->editProfile($userId, $name, $about, $email, $location);
                header('Location: /profileCompany');
                exit();
            } else {
                $error = "All fields are required.";
            }
        }
    
        include __DIR__ . '/../views/EditProfileCompany.php';
    }


    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }

        $category = $_GET['category'] ?? 'all';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $jobs = $this->job->getLowonganByCompanyId($_SESSION['user_id'], $category);
        $companyDetails = $this->getCompanyDetails($_SESSION['user_id']);
        $totalJob = count($jobs);
        $totalPages = intval($totalJob / 5);
        if ($totalJob % 5 > 0) {
            $totalPages++;
        }

        // Calculate the offset
        $offset = ($page - 1) * 5;

        // Get 5 jobs from the offset
        $parsedJobs = array_slice($jobs, $offset, 5);

        $details = [
            'name' => $_SESSION['name'],
            'about' => $companyDetails['about'],
            'location' => $companyDetails['lokasi'],
        ];

        include __DIR__ . '/../views/CompanyHome.php';
    }


    public function profile(): void
    {
        $companyData = $this->company->getProfileById($_SESSION['user_id']);

        if (!$companyData) {
            echo "Company not found";
        }

        $companyJobs = $this->job->getLowonganByCompanyId($_SESSION['user_id'], 'all');

        include __DIR__ . "/../views/ProfileCompany.php";
    }
}
