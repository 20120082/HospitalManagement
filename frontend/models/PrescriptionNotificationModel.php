<?php
// PrescriptionNotificationModel.php
// Model gửi request tới Notification Service
function sendPrescriptionNotification($to, $patientName, $prescriptionDetail, $prescriptionTime) {
    $data = [
        'to' => $to,
        'patientName' => $patientName,
        'prescriptionDetail' => $prescriptionDetail,
        'prescriptionTime' => $prescriptionTime
    ];
    $ch = curl_init('http://localhost:8085/api/notify/prescription');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        return ['success' => false, 'error' => 'Lỗi kết nối tới Notification Service!'];
    }
    return json_decode($response, true);
}
