<?php
// models/AppointmentNotificationModel.php
// Model gửi request tới Notification Service cho lịch khám

function sendAppointmentNotification($to, $patientName, $appointmentTime, $appointmentRoom, $doctorName) {
    // Chuẩn bị dữ liệu gửi tới backend Node.js
    $data = [
        'to' => trim($to),
        'patientName' => trim($patientName),
        'appointmentTime' => trim($appointmentTime),
        'appointmentRoom' => trim($appointmentRoom),
        'doctor' => trim($doctorName) // Gửi tên bác sĩ dưới dạng string
    ];
    
    $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
    $ch = curl_init('http://localhost:8085/api/notify/appointment');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return ['success' => false, 'error' => 'Lỗi kết nối: ' . $error];
    }
    
    if ($httpCode !== 200) {
        return ['success' => false, 'error' => 'HTTP Error: ' . $httpCode];
    }
    
    $result = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['success' => false, 'error' => 'Invalid JSON response'];
    }
    return $result;
}
