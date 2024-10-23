<?php
session_start();

$sessionTimeout = 1800;

// Check if the session is set and if it has expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionTimeout)) {
    session_unset();
    session_destroy();
    header("Location: /login");
    exit;
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();

spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        include $file;
    }
});

include 'Router.php';

use controllers\JobController;
use controllers\JobseekerController;
use controllers\SiteController;
use controllers\UserController;
use controllers\CompanyController;
use controllers\LamaranController;

$router = new Router();

// [Controller] : Controller Class
// Eg: UserController::class
// [function] : Controller Function
// Eg: home => home() function in UserController
// [method] : HTTP Method
// Eg: GET, POST, PUT, DELETE
// [path] : URL Path
// Eg: /, /login, /dashboard
//$router->add([method], '[path]', [[Controller]::class, '[function]']);
// Eg: $router->add('GET', '/', [UserController::class, 'home']);



$router->add('GET', '/', [UserController::class, 'home']);
$router->add('GET', '', [UserController::class, 'home']);


$router->add('GET', '/login', [UserController::class, 'login']);
$router->add('POST', '/login', [UserController::class, 'login']);
$router->add('GET', '/logout', [UserController::class, 'logout']);

$router->add('GET', '/register', [UserController::class, 'register']);
$router->add('POST', '/register', [UserController::class, 'register']);

$router->add('GET', '/dashboard', [SiteController::class, 'dashboard']);
$router->add('GET', '/api/jobs', [JobController::class, 'getJobs']);

$router->add('GET', '/tambahLowongan', [CompanyController::class, 'tambahLowongan']);
$router->add('POST', '/tambahLowongan', [CompanyController::class, 'tambahLowongan']);

$router->add('GET', '/getAllJobs', [JobController::class, 'getAllJobs']);
$router->add('GET', '/getCategoryJobs', [JobController::class, 'getCategoryJobs']);



$router->add('GET', '/editLowongan', [CompanyController::class, 'ambilLowongan']);
$router->add('POST', '/editLowongan', [CompanyController::class, 'editLowongan']);

$router->add('GET', '/riwayatLamaran', [JobController::class, 'seeLamaran']);

$router->add('GET', '/editProfileCompany', [CompanyController::class, 'ambilProfile']);
$router->add('POST', '/editProfileCompany', [CompanyController::class, 'editProfile']);

$router->add('GET', '/detaillowongan', [JobController::class, 'detailLowonganJobseeker']);


$router->add('GET', '/Companyprofile', [CompanyController::class, 'profile']);


$router->add('GET', '/detailLowonganCompany', [JobController::class, 'detailLowonganCompany']);
$router->add('GET', '/closeLowonganCompany', [JobController::class, 'closeLowonganCompany']);
$router->add('GET', '/deleteLowonganCompany', [JobController::class, 'deleteLowonganCompany']);

$router->add('GET', '/lamaran', [JobseekerController::class, 'lamaran']);
$router->add('POST', '/submitApplication', [LamaranController::class, 'submitLamaran']);

$router->add('GET', '/detaillamaran', [CompanyController::class, 'detailLamaran']);

$router->add('POST', '/updateLamaranStatus', [CompanyController::class, 'updateLamaranStatus']);

$router->add('GET', '/getFilteredJobs', [JobController::class, 'getFilteredJobs']);

$path = $_SERVER['REQUEST_URI'];
$router->dispatch($path);
