<?php
require_once 'models/Prescription.php';

class PrescriptionController {
    private $model;

    public function __construct() {
        $this->model = new Prescription();
    }

    public function index() {
        require_once 'views/prescription_index.php';
    }

    public function createPage()
    {
        $medicines = $this->model->getAllMedicines();
        require_once 'views/create_prescription_page.php';
    }
    public function deletePage()
    {
        $prescriptions = $this->model->getAllPrescriptions();
        require_once 'views/delete_prescription_page.php';
    }
    public function updatePage()
    {
        $prescriptions = $this->model->getAllPrescriptions();
        require_once 'views/update_prescription_page.php';
    }
    public function listPage()
    {
        $prescriptions = $this->model->getAllPrescriptions();
        require_once 'views/list_prescription_page.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $details = [];
            $idMedicines = $_POST['idMedicine'] ?? [];
            $quantities = $_POST['quantity'] ?? [];
            $units = $_POST['unit'] ?? [];
            $prices = $_POST['price'] ?? [];

            foreach ($idMedicines as $index => $idMedicine) {
                if (!empty($idMedicine) && !empty($quantities[$index])) {
                    $details[] = [
                        'idMedicine' => (int)$idMedicine,
                        'quantity' => (float)$quantities[$index],
                        'unit' => $units[$index],
                        'price' => (float)$prices[$index]
                    ];
                }
            }

            $data = [
                'idPatient' => (int)$_POST['idPatient'],
                'createdDate' => $_POST['createdDate'],
                'status' => $_POST['status'],
                'details' => $details
            ];

            $result = $this->model->createPrescription($data);
            require_once 'views/create_prescription_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prescriptionId = $_POST['prescriptionId'];
            $status = $_POST['status'];

            $result = $this->model->updatePrescriptionStatus($prescriptionId, $status);
            require_once 'views/update_prescription_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prescriptionId = $_POST['prescriptionId'];
            $result = $this->model->deletePrescription($prescriptionId);
            require_once 'views/delete_prescription_result.php';
        } else {
            header('Location: index.php');
        }
    }

    public function viewDetails() {
        $prescriptionId = $_GET['id'] ?? null;
        if ($prescriptionId) {
            $prescriptions = $this->model->getAllPrescriptions();
            $medicines = $this->model->getAllMedicines();
            $prescription = null;
            foreach ($prescriptions as $p) {
                
                if ($p['id'] == $prescriptionId) {
                    $prescription = $p;
                    break;
                }
            }
            
            if ($prescription) {
                $details = $prescription['details'] ?? [];
                
                foreach ($details as &$detail) {
                    foreach ($medicines as $medicine) {
                        if ($medicine['id'] == $detail['idMedicine']) {
                            $detail['medicineName'] = $medicine['name'];
                            break;
                        }
                    }
                }
                require_once 'views/view_prescriptiondetails.php';
            } else {
                $result = ['success' => false, 'message' => 'Prescription not found'];
                require_once 'views/view_prescriptiondetails_result.php';
            }
        } else {
            header('Location: index.php');
        }
    }
}
