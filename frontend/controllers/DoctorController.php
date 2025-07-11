<?php
require_once __DIR__ . '/../models/Doctor.php';

class DoctorController {
    private $model;

    public function __construct() {
        $this->model = new Doctor();
    }

    public function index() {
        require_once 'views/doctor_index.php';
    }
     public function createPage()
    {
        $doctors = $this->model->getAllDoctors();
        require_once 'views/create_doctor_page.php';
    }
    public function deletePage()
    {
        $doctors = $this->model->getAllDoctors();
        require_once 'views/delete_doctor_page.php';
    }
    public function updatePage()
    {
        $doctors = $this->model->getAllDoctors();
        require_once 'views/update_doctor_page.php';
    }
    public function listPage()
    {
        $doctors = $this->model->getAllDoctors();
        require_once 'views/list_doctor_page.php';
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'gender' => $_POST['gender'],
                'phoneNumber' => $_POST['phoneNumber'],
                'position' => $_POST['position']
            ];
            $result = $this->model->createDoctor($data);
            require_once 'views/create_doctor_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctorId = $_POST['doctorId'];
            $data = [
                'name' => $_POST['name'],
                'gender' => $_POST['gender'],
                'phoneNumber' => $_POST['phoneNumber'],
                'position' => $_POST['position']
            ];
            $result = $this->model->updateDoctor($doctorId, $data);
            require_once 'views/update_doctor_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctorId = $_POST['doctorId'];
            $result = $this->model->deleteDoctor($doctorId);
            require_once 'views/delete_doctor_result.php';
        } else {
            header('Location: index.php');
        }
    }
}