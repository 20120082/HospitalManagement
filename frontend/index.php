<?php
session_start();
$action = $_GET['action'] ?? 'index';
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
switch ($controllerName) {
    case 'Prescription':
        require_once 'controllers/PrescriptionController.php';
        $controller = new PrescriptionController();
        break;

    case 'Medicine':
        require_once 'controllers/MedicineController.php';
        $controller = new MedicineController();
        break;
    case 'Doctor':
        require_once 'controllers/DoctorController.php';
        $controller = new DoctorController();
        break;
    case 'Appointment':
        require_once 'controllers/AppointmentController.php';
        $controller = new AppointmentController();
        break;
    case 'Notification':
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        break;
    case 'Auth':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        break; 
    case 'Report':
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
        case 'login':
            $controller->login($_POST['username'], $_POST['password']);
            break;
        case 'logout':
            $controller->logout();
            break; 
        case 'dashboard':
            $controller->dashboard();
            break;
        case 'reportPage':
            $controller->reportPage();
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
        default:
            if (method_exists($controller, 'index')) {
                $controller->index();
            } else {
                require_once 'views/homepage.php';
            }
    }
} else {
    require_once 'views/views_auth/login.php';
}