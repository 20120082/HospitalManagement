<?php
require_once 'models/Appointment.php';

class AppointmentController {
    private $model;

    public function __construct() {
        $this->model = new Appointment();
    }

    public function index() {
        $appointments = $this->model->getAllAppointments();
        $doctors=  $this->model->getAllDoctors();
        require_once 'views/views_appointment/appointment_index.php';
    }
    public function createPage()
    {
        $rooms=$this->model->getAllRooms();
        $patients=$this->model->getAllPatients();
        $appointments = $this->model->getAllAppointments();
        $doctors=  $this->model->getAllDoctors();
        require_once 'views/views_appointment/create_appointment_page.php';
    }
    public function deletePage()
    {
        $rooms=$this->model->getAllRooms();
        $patients=$this->model->getAllPatients();
        $appointments = $this->model->getAllAppointments();
        $doctors=  $this->model->getAllDoctors();
        require_once 'views/views_appointment/delete_appointment_page.php';
    }
    public function updatePage()
    {
        $rooms=$this->model->getAllRooms();
        $patients=$this->model->getAllPatients();
        $appointments = $this->model->getAllAppointments();
        $doctors=  $this->model->getAllDoctors();
        require_once 'views/views_appointment/update_appointment_page.php';
    }
    public function listPage()
    {
        $rooms=$this->model->getAllRooms();
        $patients=$this->model->getAllPatients();
        $appointments = $this->model->getAllAppointments();
        $doctors=  $this->model->getAllDoctors();
        require_once 'views/views_appointment/list_appointment_page.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'idPatient' => $_POST['idPatient'],
                'idDoctor' => (int)$_POST['idDoctor'],
                'idRoom' => $_POST['idRoom'],
                'startTime' => $_POST['startTime'],
                'status' => $_POST['status']
            ];
            $result = $this->model->createAppointment($data);
            require_once 'views/views_appointment/create_appointment_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointmentId'];
            $data = [
                'idPatient' => $_POST['idPatient'],
                'idDoctor' => (int)$_POST['idDoctor'],
                'idRoom' => $_POST['idRoom'],
                'startTime' => $_POST['startTime'],
                'status' => $_POST['status']
            ];
            $result = $this->model->updateAppointment($appointmentId, $data);
            require_once 'views/views_appointment/update_appointment_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointmentId'];
            $result = $this->model->deleteAppointment($appointmentId);
            require_once 'views/views_appointment/delete_appointment_result.php';
        } else {
            header('Location: index.php');
        }
    }

    // Gửi thông báo lịch khám qua Notification Service
    public function sendAppointmentNotification() {
        require_once 'models/AppointmentNotificationModel.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $to = $_POST['to'] ?? '';
            $patientName = $_POST['patientName'] ?? '';
            $appointmentTime = $_POST['appointmentTime'] ?? '';
            $appointmentRoom = $_POST['appointmentRoom'] ?? '';
            $doctorName = $_POST['appointmentDoctor'] ?? '';
            
            // Validate dữ liệu
            if (empty($to) || empty($patientName) || empty($appointmentTime) || empty($doctorName)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Thiếu thông tin bắt buộc']);
                exit;
            }
            
            $result = sendAppointmentNotification($to, $patientName, $appointmentTime, $appointmentRoom, $doctorName);
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
            exit;
        }
    }
}