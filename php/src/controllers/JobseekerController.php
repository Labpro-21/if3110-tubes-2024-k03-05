<?php

namespace controllers;

class JobseekerController
{

    public function dashboard()
    {
        echo "Welcome to Jobseeker Dashboard";
    }

    public function lamaran()
    {
        include __DIR__ . '/../views/LamaranJobseeker.php';
    }

}