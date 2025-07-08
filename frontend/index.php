<?php
$action = $_GET['action'] ?? 'index';
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : '';
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
        case 'ListPage':
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
        default:
            if (method_exists($controller, 'index')) {
                $controller->index();
            } else {
                require_once 'views/homepage.php';
            }
    }
} else {
    require_once 'views/homepage.php';
}