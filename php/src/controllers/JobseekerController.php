<?php

namespace controllers;

use models\Job;
use config\Database;

class JobseekerController
{
    private $conn;
    private $job;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->job = new Job($this->conn);
    }

    public function getUserDetails($userId) {
        $query = "SELECT * FROM user WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        return $stmt->fetch();
    }


    public function dashboard(): void
    {
        // Check if the user is logged in and has the 'jobseeker' role
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userDetails = $this->getUserDetails($userId);
        $details = [
            'name' => $_SESSION['name'],
            'email' => $userDetails['email'],
            'role' => $userDetails['role'],
        ];

        // Include the view
        include __DIR__ . '/../views/jobsHomepage.php';
    }



    public function lamaran(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            exit;
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        if (!isset($_GET['lowonganId'])) {
            header("Location: /dashboard");
            exit();
        }

        // Check if the jobs is open
        $id = (int)$_GET['lowonganId'];
        $job = $this->job->getLowonganById($id);

        if (!$job) {
            header("Location: /dashboard");
            exit();
        }

        if ($job['is_open'] !== 1) {
            header("Location: /dashboard");
            exit();
        }

        include __DIR__ . '/../views/LamaranJobseeker.php';
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userDetails = $this->getUserDetails($userId);

        $userDetails['image_path'] = $userDetails['image_path'] ?? '../public/images/paper.webp';
        $userDetails['banner_path'] = $userDetails['banner_path'] ?? '../public/images/linkedinbanner.webp';


        include __DIR__ . '/../views/JobseekerProfile.php';
    }

    public function editProfile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];

            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === 0) {
                $imagePath = $this->uploadImage($_FILES['profileImage']);
            }

            if (isset($_FILES['bannerImage']) && $_FILES['bannerImage']['error'] === 0) {
                $bannerPath = $this->uploadImage($_FILES['bannerImage']);
            }

            $query = "UPDATE user 
            SET image_path = :image, banner_path = :banner 
            WHERE user_id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':image', $imagePath);
            $stmt->bindParam(':banner', $bannerPath);
            $stmt->bindParam(':id', $userId);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Profile updated successfully']);
            } else {
                echo json_encode(['message' => 'Failed to update profile']);
            }
            exit;
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userDetails = $this->getUserDetails($userId);

        include __DIR__ . '/../views/EditJobseekerProfile.php';
    }

    private function uploadImage(mixed $image): string
    {
        $targetDir = __DIR__ . '/../uploads/';
        $fileName = basename($image['name']);
        $newFileName = md5($fileName) . '-' . $fileName;
        $newFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $newFilePath)) {
            return '/../uploads/' . $newFileName;
        }

        return '';
    }
}