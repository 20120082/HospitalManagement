<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Check if user has access to reports
if (!isset($_SESSION['role_name']) || !in_array($_SESSION['role_name'], ['admin', 'doctor', 'manager'])) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// Set headers for API response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// Include the ReportController
require_once '../controllers/ReportController.php';

$reportController = new ReportController();
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'getPatientStats':
            $reportController->getPatientStats();
            break;
            
        case 'getPrescriptionStats':
            $reportController->getPrescriptionStats();
            break;
            
        case 'getMonthlyReport':
            $reportController->getMonthlyReport();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
