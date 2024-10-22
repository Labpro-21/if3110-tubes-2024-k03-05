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
            header("Location: /login");
            exit();
        }

        if ($_SESSION['role'] === 'jobseeker') {
            $this->jobsekerController->dashboard();
        } else if ($_SESSION['role'] === 'company') {
            $this->companyController->dashboard();
        } else {
            echo "Invalid role";
        }
    }
}