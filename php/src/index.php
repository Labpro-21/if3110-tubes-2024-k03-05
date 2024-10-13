<?php
require_once 'controllers/UserController.php';

$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/':
        (new UserController())->home();
        break;
    case '/login':
        (new UserController())->login();
        break;
    case '/register':
        (new UserController())->register();
        break;
    default:
        echo '404 Not Found';
        break;
}
