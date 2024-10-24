<?php

namespace controllers;

class SiteController
{
    private CompanyController $companyController;
    private JobseekerController $jobsekerController;

    public function __construct()
    {
        $this->companyController = new CompanyController();
        $this->jobsekerController = new JobseekerController();
    }

    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id'])) {
            include __DIR__ . '/../views/GuestHomepage.php';
            exit();
        }

        if ($_SESSION['role'] === 'jobseeker') {
            $this->jobsekerController->dashboard();
        } else if ($_SESSION['role'] === 'company') {
            $this->companyController->dashboard();
        } else {
            include __DIR__ . '/../views/404.php';
        }
    }

    public function profile(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SESSION['role'] === 'jobseeker') {
            $this->jobsekerController->profile();
        } else if ($_SESSION['role'] === 'company') {
            $this->companyController->profile();
        } else {
            include __DIR__ . '/../views/404.php';
        }
    }

    public function getFiles(): void
    {
        $filePath = $_GET['file'];
        $baseDir = __DIR__ . '/../uploads/';
        $realBase = realpath($baseDir);
        $realUserPath = realpath($baseDir . $filePath);

        if ($realUserPath === false || !str_starts_with($realUserPath, $realBase)) {
            http_response_code(404);
            exit('File not found');
        }

        if (file_exists($realUserPath)) {
            header('Content-Type: ' . mime_content_type($realUserPath));
            header('Content-Length: ' . filesize($realUserPath));
            readfile($realUserPath);
            exit;
        } else {
            http_response_code(404);
            exit('File not found');
        }
    }
}
