<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // Hiển thị trang đăng nhập
    public function loginPage() {
        // Nếu đã đăng nhập, chuyển hướng đến dashboard
        if(isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role_name']);
            return;
        }
        require_once 'views/auth/login.php';
    }

    // Xử lý đăng nhập
    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // Validation
            if(empty($username) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ thông tin';
                $this->user->logLoginAttempt($username, $ip_address, false, 'Empty credentials');
                require_once 'views/auth/login.php';
                return;
            }

            // Kiểm tra đăng nhập
            $user_data = $this->user->login($username, $password);
            
            if($user_data) {
                // Lưu thông tin vào session (session đã được khởi động trong index.php)
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['full_name'] = $user_data['full_name'];
                $_SESSION['role_name'] = $user_data['role_name'];
                $_SESSION['role_id'] = $user_data['role_id'];
                
                // Tạo session trong database
                $session_id = session_id();
                $this->user->createSession($user_data['user_id'], $session_id);
                
                // Log thành công
                $this->user->logLoginAttempt($username, $ip_address, true);
                
                // Chuyển hướng đến dashboard tương ứng
                $this->redirectToDashboard($user_data['role_name']);
            } else {
                $error = 'Tên đăng nhập hoặc mật khẩu không chính xác';
                $this->user->logLoginAttempt($username, $ip_address, false, 'Invalid credentials');
                require_once 'views/auth/login.php';
            }
        }
    }

    // Đăng xuất
    public function logout() {
        // Xóa session trong database
        if(isset($_SESSION['user_id'])) {
            $this->user->destroySession(session_id());
        }
        
        // Xóa session PHP
        session_destroy();
        
        // Chuyển hướng về trang đăng nhập
        header('Location: index.php?controller=Auth&action=loginPage');
        exit();
    }

    // Chuyển hướng đến dashboard tương ứng
    private function redirectToDashboard($role_name) {
        switch($role_name) {
            case 'admin':
                header('Location: index.php?controller=Auth&action=adminDashboard');
                break;
            case 'doctor':
                header('Location: index.php?controller=Auth&action=doctorDashboard');
                break;
            case 'nurse':
                header('Location: index.php?controller=Auth&action=nurseDashboard');
                break;
            case 'receptionist':
                header('Location: index.php?controller=Auth&action=receptionistDashboard');
                break;
            default:
                header('Location: index.php?controller=Auth&action=loginPage');
        }
        exit();
    }

    // Dashboard cho Admin
    public function adminDashboard() {
        $this->checkPermission('admin_dashboard');
        // Kiểm tra thêm role
        if($_SESSION['role_name'] != 'admin') {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
        require_once 'views/auth/admin_dashboard.php';
    }

    // Dashboard cho Doctor
    public function doctorDashboard() {
        $this->checkPermission('doctor_dashboard');
        // Kiểm tra thêm role
        if($_SESSION['role_name'] != 'doctor') {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
        require_once 'views/auth/doctor_dashboard.php';
    }

    // Dashboard cho Nurse
    public function nurseDashboard() {
        $this->checkPermission('nurse_dashboard');
        // Kiểm tra thêm role
        if($_SESSION['role_name'] != 'nurse') {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
        require_once 'views/auth/nurse_dashboard.php';
    }

    // Dashboard cho Receptionist
    public function receptionistDashboard() {
        $this->checkPermission('receptionist_dashboard');
        // Kiểm tra thêm role
        if($_SESSION['role_name'] != 'receptionist') {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
        require_once 'views/auth/receptionist_dashboard.php';
    }

    // Kiểm tra quyền truy cập
    private function checkPermission($permission) {
        // Session đã được khởi động trong index.php
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=loginPage');
            exit();
        }

        // Enable lại permission check sau khi database hoạt động
        if(!$this->user->hasPermission($_SESSION['user_id'], $permission)) {
            header('Location: index.php?controller=Auth&action=accessDenied');
            exit();
        }
    }

    // Trang từ chối truy cập
    public function accessDenied() {
        require_once 'views/auth/access_denied.php';
    }
}
?>
