<?php
require_once 'models/Patient.php';

$action = $_GET['action'] ?? 'listPage';

switch ($action) {
    case 'listPage':
        $page = isset($_GET['page']) ? max(0, intval($_GET['page']) - 1) : 0;
        $size = isset($_GET['size']) ? intval($_GET['size']) : 10;
        try {
            $patients = Patient::getAllPaged($page, $size);
            require_once 'views/patient/list_patient_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải danh sách bệnh nhân: " . $e->getMessage();
            require_once 'views/patient/list_patient_page.php';
        }
        break;

    case 'viewPage':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $error = "Thiếu ID bệnh nhân.";
            require_once 'views/patient/view_patient_page.php';
            break;
        }

        try {
            $patient = Patient::getPatientById($id);
            require_once 'views/patient/view_patient_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải thông tin bệnh nhân: " . $e->getMessage();
            require_once 'views/patient/view_patient_page.php';
        }
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Kiểm tra input
            $requiredFields = ['fullName', 'gender', 'dateOfBirth', 'phoneNumber'];
            $missing = [];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $missing[] = $field;
                }
            }

            if (!empty($missing)) {
                $error = "Thiếu thông tin bắt buộc: " . implode(', ', $missing);
                require_once 'views/patient/add_patient_page.php';
                break;
            }

            try {
                $data = [
                    'fullName' => $_POST['fullName'],
                    'gender' => $_POST['gender'],
                    'dateOfBirth' => $_POST['dateOfBirth'],
                    'phoneNumber' => $_POST['phoneNumber'],
                    'email' => $_POST['email'],
                    'address' => $_POST['address']
                ];

                $result = Patient::createPatient($data);

                if (isset($result['error'])) {
                    // Nếu API có key 'error' thì xem là lỗi
                    $_SESSION['error'] = "Tạo không thành công: " . $result['error'];
                    require_once 'views/patient/add_patient_page.php';
                } else {
                    // Nếu có status là success thì redirect
                    $_SESSION['success'] = $result['message'] ?? 'Tạo bệnh nhân thành công.';
                    header("Location: index.php?controller=Patient&action=listPage");
                    exit;
                }



                if (isset($result['message']) && !empty($result['message'])) {
                    $error = "Lỗi: " . $result['message'];
                    require_once 'views/patient/add_patient_page.php';
                    break;
                }

                // Thành công
                header('Location: index.php?controller=Patient&action=listPage');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
                require_once 'views/patient/add_patient_page.php';
                break;
            }
        } else {
            require_once 'views/patient/add_patient_page.php';
        }
        break;


    case 'update':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $error = "Thiếu ID cần cập nhật.";
            require_once 'views/patient/update_patient_page.php';
            break;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            try {
                $result = Patient::updatePatient($id, $data);
                if (isset($result['status']) && $result['status'] === 'error') {
                    $error = "Lỗi từ API: " . $result['message'];
                } else {
                    header('Location: index.php?controller=Patient&action=viewPage&id=' . $id);
                    exit;
                }
            } catch (Exception $e) {
                $error = "Không thể cập nhật bệnh nhân: " . $e->getMessage();
            }
        }

        try {
            $patient = Patient::getPatientById($id);
        } catch (Exception $e) {
            $error = "Không thể tải thông tin bệnh nhân: " . $e->getMessage();
        }

        require_once 'views/patient/update_patient_page.php';
        break;

    case 'delete':
    case 'deletePatient':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $error = "Thiếu ID bệnh nhân.";
            require_once 'views/patient/list_patient_page.php';
            break;
        }

        try {
            Patient::deletePatient($id);
            header('Location: index.php?controller=Patient&action=listPage');
            exit;
        } catch (Exception $e) {
            $error = "Không thể xoá bệnh nhân: " . $e->getMessage();
            require_once 'views/patient/list_patient_page.php';
        }
        break;

    case 'search':
        $criteria = $_GET;
        try {
            $patients = Patient::searchPatients($criteria);
            require_once 'views/patient/search_patient_page.php';
        } catch (Exception $e) {
            $error = "Không thể tìm kiếm bệnh nhân: " . $e->getMessage();
            require_once 'views/patient/search_patient_page.php';
        }
        break;

    case 'countByMonth':
        $year = $_GET['year'] ?? null;
        $month = $_GET['month'] ?? null;
        if (!$year || !$month) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Thiếu tham số year hoặc month']);
            exit;
        }

        try {
            $result = Patient::countPatientsByMonth($year, $month);
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Lỗi từ API: ' . $e->getMessage()]);
        }
        break;

    default:
        $error = "Hành động không hợp lệ.";
        require_once 'views/patient/list_patient_page.php';
        break;
}
