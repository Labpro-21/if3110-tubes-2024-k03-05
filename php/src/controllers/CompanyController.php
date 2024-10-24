<?php


namespace controllers;

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/Job.php';

use config\Database;
use models\Job;
use models\Company;
use models\Lamaran;

class CompanyController
{
    private $conn;
    private $job;
    private $company;
    private $lamaran;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->job = new Job($this->conn);
        $this->company = new Company($this->conn);
        $this->lamaran = new Lamaran($this->conn);
    }

    public function tambahLowongan(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $position = $_POST['Position'];
            $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
            $type = $_POST['Type'];
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
    public function ambilLowongan(): void
    {
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

        include __DIR__ . "/../views/EditLowongan.php";
    }

    public function editLowongan(): void
    {
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

    public function ambilProfile(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }

        if (isset($_SESSION['user_id'])) {
            $userId = (int)$_SESSION['user_id'];
        } else {
            echo 'masuk';
            header("Location: /dashboard");
            exit();
        }

        $companyData = $this->company->getProfileById($userId);

        if (!$companyData) {
            header("Location: /dashboard");
            exit();
        }

        include __DIR__ . "/../views/EditProfileCompany.php";
    }

    public function editProfile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'];
            $about = $data['about'];
            $email = $data['email'];
            $location = $data['location'];

            if (!empty($name) && !empty($about) && !empty($email) && !empty($location)) {
                $userId = (int)$_SESSION['user_id'];

                // Check if the email already exists for another user
                if ($this->company->isEmailExists($email, $userId)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Email already exists']);
                    exit();
                }

                $this->company->editProfile($userId, $name, $about, $email, $location);
                http_response_code(200);
                echo json_encode(['message' => 'Profile updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'All fields are required']);
            }
            exit();
        }
        include __DIR__ . '/../views/EditProfileCompany.php';
    }


    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header("Location: /login");
            exit();
        }


        $companyDetails = $this->company->getCompanyDetails($_SESSION['user_id']);

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
        foreach ($companyJobs as $key => $company) {
            $companyJobs[$key]['deskripsi'] = preg_replace('/<\/?p>/', '', html_entity_decode($company['deskripsi']));
        }

        include __DIR__ . "/../views/ProfileCompany.php";
    }

    public function detailLamaran()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (!isset($_GET['lamaran_id'])) {
                header('/dashboard');
                exit;
            }

            $id = $_GET['lamaran_id'];

            $lamaran = $this->lamaran->getLamaranById($id);
            $status = $lamaran['status'];

            include __DIR__ . "/../views/DetailLamaran.php";
        }
        http_response_code(405);
        return json_encode(['message' => 'Method not allowed']);
    }

    public function updateLamaranStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['lamaranId'];
            $status = $data['status'];
            $reason = $data['reason'];

            if ($this->lamaran->updateStatus($id, $status, $reason)){
                http_response_code(200);
                return json_encode(['message' => 'Status updated']);
            } else {
                http_response_code(400);
                return json_encode(['message' => 'Failed to update status']);
            }

        }
        http_response_code(405);
        return json_encode(['message' => 'Method not allowed']);
    }


    public function getFilteredJobsComp(): void
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

        $jobs = $this->job->getJobsByCategoryId($_SESSION['user_id'], $category, $categoryLoc, $categorySort, $searchTerm);

        $totalJobs = count($jobs);
        $totalPages = ceil($totalJobs / $limit);


        $jobs = array_slice($jobs, $offset, $limit);

        // Jobs.description is stored as HTML entities in the database
        // Decode the HTML entities to display the description properly
        // Trim <p> tags from the description
        foreach ($jobs as $key => $job) {
            $jobs[$key]['deskripsi'] = preg_replace('/<\/?p>/', '', html_entity_decode($job['deskripsi']));
        }

        header('Content-Type: application/json');
        echo json_encode(['jobs' => $jobs, 'totalPages' => $totalPages, 'currentPage' => $page]);
    }
}
