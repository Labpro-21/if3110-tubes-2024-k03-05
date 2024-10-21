<?php

namespace controllers;

class SiteController
{

    public function dashboard(): void
    {
       include __DIR__ . '/../views/CompanyHome.php';
    }
}