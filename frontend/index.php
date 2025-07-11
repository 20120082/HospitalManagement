<?php
session_start();

// Import middleware
require_once 'middleware/AuthMiddleware.php';
$auth = new AuthMiddleware();

$action = $_GET['action'] ?? 'index';
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : '';

switch ($controllerName) {
    case 'Auth':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        break;
    case 'Prescription':
        // Kiểm tra quyền truy cập Prescription
        $auth->checkControllerAccess('Prescription', $action);
        require_once 'controllers/PrescriptionController.php';
        $controller = new PrescriptionController();
        break;

    case 'Medicine':
        // Kiểm tra quyền truy cập Medicine
        $auth->checkControllerAccess('Medicine', $action);
        require_once 'controllers/MedicineController.php';
        $controller = new MedicineController();
        break;
    case 'Doctor':
        // Kiểm tra quyền truy cập Doctor
        $auth->checkControllerAccess('Doctor', $action);
        require_once 'controllers/DoctorController.php';
        $controller = new DoctorController();
        break;
    case 'Appointment':
        // Kiểm tra quyền truy cập Appointment - Tạm thời disable
        // $auth->checkControllerAccess('Appointment', $action);
        require_once 'controllers/AppointmentController.php';
        $controller = new AppointmentController();
        break;
    case 'User':
        // Kiểm tra quyền truy cập User (chỉ admin)
        $auth->checkControllerAccess('User', $action);
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        break;
    case 'Notification':
        // Kiểm tra quyền truy cập Notification - Tạm thời disable
        // $auth->checkControllerAccess('Notification', $action);
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        break;
    case 'Report':
        // Kiểm tra quyền truy cập Report
        $auth->checkControllerAccess('Report', $action);
        require_once 'controllers/ReportController.php';
        $controller = new ReportController();
        break;
    default:
        $controller = null;
}



if(isset($_GET['controller']) && $controller) {
    switch ($action) 
    {
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
        // Report controller specific actions
        case 'getPatientStats':
            if (method_exists($controller, 'getPatientStats')) {
                $controller->getPatientStats();
            }
            break;
        case 'getPrescriptionStats':
            if (method_exists($controller, 'getPrescriptionStats')) {
                $controller->getPrescriptionStats();
            }
            break;
        case 'getMonthlyReport':
            if (method_exists($controller, 'getMonthlyReport')) {
                $controller->getMonthlyReport();
            }
            break;
        case 'test':
            if (method_exists($controller, 'test')) {
                $controller->test();
            }
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