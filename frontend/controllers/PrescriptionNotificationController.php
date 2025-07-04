<?php
// PrescriptionNotificationController.php
// Controller xử lý gửi thông báo đơn thuốc
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../models/PrescriptionNotificationModel.php';
    $to = $_POST['to'] ?? '';
    $patientName = $_POST['patientName'] ?? '';
    $prescriptionDetail = $_POST['prescriptionDetail'] ?? '';
    $prescriptionTime = $_POST['prescriptionTime'] ?? '';
    $result = sendPrescriptionNotification($to, $patientName, $prescriptionDetail, $prescriptionTime);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
