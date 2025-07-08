<?php

class NotificationController {
    private $notificationServiceUrl = 'http://localhost:8085/api/notify';

    public function index() {
        require_once 'views/notification_index.php';
    }

    public function listPage() {
        $notifications = $this->getAllNotifications();
        $patients = $this->getAllPatients();
        
        // Xử lý thông tin bệnh nhân cho mỗi thông báo
        foreach ($notifications as &$notification) {
            $notification['patientName'] = $this->getPatientNameFromNotification($notification, $patients);
        }
        
        require_once 'views/list_notification_page.php';
    }

    public function delete() {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id) {
            $result = $this->deleteNotification($id);
            if ($result['success']) {
                $message = "Đã xóa thông báo thành công!";
            } else {
                $message = "Có lỗi xảy ra khi xóa thông báo!";
            }
        } else {
            $message = "ID thông báo không hợp lệ!";
        }
        require_once 'views/delete_notification_result.php';
    }

    public function deleteAll() {
        $result = $this->deleteAllNotifications();
        if ($result['success']) {
            $message = "Đã xóa tất cả thông báo thành công!";
        } else {
            $message = "Có lỗi xảy ra khi xóa thông báo!";
        }
        require_once 'views/delete_notification_result.php';
    }

    private function getAllNotifications() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->notificationServiceUrl . '/list');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                return $data && $data['success'] ? $data['data'] : [];
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    private function deleteNotification($id) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->notificationServiceUrl . '/' . $id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                return json_decode($response, true);
            }
            return ['success' => false];
        } catch (Exception $e) {
            return ['success' => false];
        }
    }

    private function deleteAllNotifications() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->notificationServiceUrl . '/all/clear');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                return json_decode($response, true);
            }
            return ['success' => false];
        } catch (Exception $e) {
            return ['success' => false];
        }
    }
    
    private function getAllPatients() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost:8090/api/patients');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?: [];
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getPatientNameFromNotification($notification, $patients) {
        // Trích xuất tên bệnh nhân từ nội dung thông báo
        $text = $notification['text'];
        
        // Tìm kiếm pattern "Xin chào [Tên],"
        if (preg_match('/Xin chào\s+([^,]+),/', $text, $matches)) {
            return trim($matches[1]);
        }
        
        // Fallback: tìm kiếm theo email trong danh sách bệnh nhân
        $email = $notification['to'];
        foreach ($patients as $patient) {
            if (isset($patient['email']) && $patient['email'] === $email) {
                return $patient['fullName'];
            }
        }
        
        // Nếu không tìm thấy, trả về email
        return $email;
    }
}
