<?php
session_start();

// Import middleware
require_once 'middleware/AuthMiddleware.php';
$auth = new AuthMiddleware();

$action = $_GET['action'] ?? 'index';
$controllerName = $_GET['controller'] ?? '';

// Danh sách controller dùng class
$classControllers = ['Auth', 'Prescription', 'Medicine', 'Doctor', 'Appointment', 'User', 'Notification'];
// Danh sách procedural (dùng include trực tiếp controller)
$proceduralControllers = ['Patient', 'Room', 'MedicalRecord'];

$controller = null;

// Xử lý class-based controller
if (in_array($controllerName, $classControllers)) {
    if ($controllerName !== 'Auth') {
        $auth->checkControllerAccess($controllerName, $action);
    }
    require_once "controllers/{$controllerName}Controller.php";
    $controllerClass = $controllerName . 'Controller';
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
    }
}

// Xử lý procedural controller
if (in_array($controllerName, $proceduralControllers)) {
    // Có thể kiểm tra quyền nếu muốn
    require_once "controllers/{$controllerName}Controller.php";
}


if (in_array($controllerName, ['Patient', 'Room', 'MedicalRecord'])) {
    // Đây là các controller procedural – đã require_once phía trên rồi, không làm gì thêm
} else if (isset($_GET['controller']) && $controller) {
    switch ($action) {
        // actions
        case 'create':
            $controller->create();
            break;
        case 'updateStatus':
            $controller->updateStatus();
            break;
        case 'delete':
            $controller->delete();
            break;
        case 'viewDetails':
            $controller->viewDetails();
            break;
        case 'CreatePage':
            $controller->createPage();
            break;
        case 'DeletePage':
            $controller->deletePage();
            break;
        case 'UpdatePage':
            $controller->updatePage();
            break;
        case 'listPage':
            $controller->listPage();
            break;
        case 'ListPage':  // Giữ lại để tương thích
            $controller->listPage();
            break;
        case 'update':
            $controller->update();
            break;
        case 'sendAppointmentNotification':
            if (method_exists($controller, 'sendAppointmentNotification')) {
                $controller->sendAppointmentNotification();
            }
            break;
        case 'deleteAll':
            if (method_exists($controller, 'deleteAll')) {
                $controller->deleteAll();
            }
            break;
        case 'loginPage':
            $controller->loginPage();
            break;
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'adminDashboard':
            $controller->adminDashboard();
            break;
        case 'doctorDashboard':
            $controller->doctorDashboard();
            break;
        case 'nurseDashboard':
            $controller->nurseDashboard();
            break;
        case 'receptionistDashboard':
            $controller->receptionistDashboard();
            break;
        case 'accessDenied':
            $controller->accessDenied();
            break;
        case 'store':
            $controller->store();
            break;
        case 'show':
            $controller->show();
            break;
        case 'edit':
            $controller->edit();
            break;
        case 'toggleStatus':
            $controller->toggleStatus();
            break;
        default:
            if (method_exists($controller, 'index')) {
                $controller->index();
            } else {
                // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
                if (!isset($_SESSION['user_id'])) {
                    header('Location: index.php?controller=Auth&action=loginPage');
                    exit();
                }
                require_once 'views/homepage.php';
            }
    }
} else {
    // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?controller=Auth&action=loginPage');
        exit();
    }
    require_once 'views/homepage.php';
}
