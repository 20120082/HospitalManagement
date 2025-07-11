<?php
require_once 'models/MedicalRecord.php';
require_once 'models/Doctor.php';

$action = $_GET['action'] ?? 'listPage';

switch ($action) {
    case 'listPage':
        $page = isset($_GET['page']) ? max(0, intval($_GET['page']) - 1) : 0;
        $size = isset($_GET['size']) ? intval($_GET['size']) : 10;
        try {
            $records = MedicalRecord::getAllPaged($page, $size);
            require_once 'views/medical_record/list_medical_record_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải danh sách bệnh án: " . $e->getMessage();
            require_once 'views/medical_record/list_medical_record_page.php';
        }
        break;

    case 'createPage':
        try {
            $rooms = MedicalRecord::getAllRooms();
            $doctors = MedicalRecord::getAllDoctors(); 
            $patients = MedicalRecord::getAllPatients();
            require_once 'views/medical_record/create_medical_record_page.php';
        } catch (Exception $e) {
            $rooms = [];
            $doctors = [];
            $error = "Không thể tải dữ liệu cần thiết: " . $e->getMessage();
            require_once 'views/medical_record/create_medical_record_page.php';
        }
        try {
            $patients = MedicalRecord::getAllPatients();
        } catch (Exception $e) {
            $patients = [];
        }

        try {
            $rooms = MedicalRecord::getAllRooms();
        } catch (Exception $e) {
            $rooms = [];
        }

        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            try {
                MedicalRecord::createMedicalRecord($data);
                header("Location: index.php?controller=MedicalRecord&action=listPage");
                exit();
            } catch (Exception $e) {
                $error = "Tạo bệnh án thất bại: " . $e->getMessage();
                require_once 'views/medical_record/create_medical_record_page.php';
            }
        }
        break;

    case 'updatePage':
        $id = $_GET['id'] ?? '';
        try {
            $record = MedicalRecord::getMedicalRecordById($id);
            require_once 'views/medical_record/update_medical_record_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải thông tin bệnh án.";
            require_once 'views/medical_record/update_medical_record_page.php';
        }
        break;

    case 'update':
        $id = $_GET['id'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            try {
                MedicalRecord::updateMedicalRecord($id, $data);
                header("Location: index.php?controller=MedicalRecord&action=listPage");
                exit();
            } catch (Exception $e) {
                $error = "Cập nhật bệnh án thất bại: " . $e->getMessage();
                $record = $data;
                require_once 'views/medical_record/update_medical_record_page.php';
            }
        }
        break;

    case 'delete':
        $id = $_GET['id'] ?? '';
        try {
            MedicalRecord::deleteMedicalRecord($id);
            header("Location: index.php?controller=MedicalRecord&action=listPage");
            exit();
        } catch (Exception $e) {
            $error = "Xóa bệnh án thất bại: " . $e->getMessage();
            $page = 0;
            $size = 10;
            $records = MedicalRecord::getAllPaged($page, $size);
            require_once 'views/medical_record/list_medical_record_page.php';
        }
        break;

    case 'search':
        $criteria = $_GET;
        try {
            require_once 'views/medical_record/list_medical_record_page.php';
        } catch (Exception $e) {
            $error = "Không thể tìm kiếm bệnh án: " . $e->getMessage();
            require_once 'views/medical_record/list_medical_record_page.php';
        }
        break;

    default:
        http_response_code(404);
        echo "Không tìm thấy chức năng yêu cầu.";
        break;
}
