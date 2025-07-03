<?php
require_once 'controllers/PrescriptionController.php';
require_once 'controllers/DoctorController.php';

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
        $controller = new DoctorController();
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