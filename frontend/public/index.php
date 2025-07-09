<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/ReportController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

error_log("Request URI: $path, Method: $method"); // Debug log

if ($path === '/service4/auth/login' && $method === 'POST') {
    error_log("Processing login for username: " . ($_POST['username'] ?? 'unknown'));
    $controller = new AuthController();
    $controller->login($_POST['username'], $_POST['password']);
} elseif ($path === '/service4/dashboard') {
    session_start();
    error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'not set'));
    if (!isset($_SESSION['user_id'])) {
        error_log("Redirecting to /service4 due to missing user_id");
        header('Location: /service4');
        exit();
    }
    if (!file_exists('../views/dashboard.php')) {
        error_log("dashboard.php not found");
        die("File dashboard.php không tồn tại!");
    }
    include '../views/dashboard.php';
} elseif ($path === '/service4/reports') {
    session_start();
    error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'not set'));
    if (!isset($_SESSION['user_id'])) {
        header('Location: /service4');
        exit();
    }
    include '../views/reports.php';
} elseif ($path === '/service4/report/generate' && $method === 'POST') {
    $controller = new ReportController();
    $controller->generate($_POST['report_type'], $_POST['month']);
} elseif ($path === '/service4/report/list' && $method === 'GET') {
    $controller = new ReportController();
    $controller->getReportList();
} else {
    error_log("Default route, showing login page");
    include '../views/login.php';
}
?>