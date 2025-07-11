<?php
require_once __DIR__ . '/../models/User.php';

class AuthMiddleware {
    private $user;
    
    public function __construct() {
        $this->user = new User();
    }
    
    // Kiểm tra đăng nhập
    public function checkLogin() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=loginPage');
            exit();
        }
    }
    
    // Kiểm tra quyền truy cập module
    public function checkPermission($required_permission) {
        $this->checkLogin();
        
        if(!$this->user->hasPermission($_SESSION['user_id'], $required_permission)) {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
    }
    
    // Kiểm tra quyền cho từng controller
    public function checkControllerAccess($controller_name, $action = 'index') {
        $this->checkLogin();
        
        $permission_map = [
            'Prescription' => 'manage_prescriptions',
            'Doctor' => 'view_patients', 
            'Medicine' => 'view_medicines',
            'Appointment' => 'manage_appointments', 
            'Notification' => 'manage_notifications'
        ];
        
        // Kiểm tra quyền đặc biệt cho từng role
        $role_name = $_SESSION['role_name'];
        
        switch($controller_name) {
            case 'Prescription':
                if(!in_array($role_name, ['admin', 'doctor', 'nurse'])) {
                    $this->accessDenied();
                }
                break;
                
            case 'Doctor':
                if(!in_array($role_name, ['admin', 'doctor'])) {
                    $this->accessDenied();
                }
                break;
                
            case 'Medicine':
                if(!in_array($role_name, ['admin', 'doctor', 'nurse'])) {
                    $this->accessDenied();
                }
                // Nurse chỉ được xem, không được tạo/sửa/xóa
                if($role_name == 'nurse' && !in_array($action, ['listPage', 'ListPage', 'index'])) {
                    $this->accessDenied();
                }
                break;
                
            case 'Appointment':
                if(!in_array($role_name, ['admin', 'doctor', 'receptionist'])) {
                    $this->accessDenied();
                }
                break;
                
            case 'Notification':
                if(!in_array($role_name, ['admin', 'receptionist'])) {
                    $this->accessDenied();
                }
                break;
                
            case 'Report':
                if(!in_array($role_name, ['admin', 'doctor', 'manager'])) {
                    $this->accessDenied();
                }
                break;
        }
    }
    
    // Chuyển hướng khi không có quyền
    private function accessDenied() {
        header('Location: index.php?controller=Auth&action=accessDenied');
        exit();
    }
    
    // Kiểm tra quyền truy cập dashboard
    public function checkDashboardAccess($dashboard_type) {
        $this->checkLogin();
        
        $role_name = $_SESSION['role_name'];
        
        if($dashboard_type != $role_name) {
            $this->accessDenied();
        }
    }
}
?>
