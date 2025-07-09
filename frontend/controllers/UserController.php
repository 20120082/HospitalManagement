<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // Hiển thị danh sách users
    public function index() {
        $users = $this->user->getAllUsers();
        require_once 'views/users/list_users.php';
    }

    // Hiển thị form tạo user mới
    public function create() {
        $roles = $this->user->getAllRoles();
        require_once 'views/users/create_user.php';
    }

    // Xử lý tạo user mới
    public function store() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $full_name = trim($_POST['full_name']);
            $role_id = (int)$_POST['role_id'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            // Validation
            $errors = [];
            
            if(empty($username)) {
                $errors[] = 'Tên đăng nhập không được để trống';
            } elseif($this->user->usernameExists($username)) {
                $errors[] = 'Tên đăng nhập đã tồn tại';
            }

            if(empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif($this->user->emailExists($email)) {
                $errors[] = 'Email đã được sử dụng';
            }

            if(empty($password) || strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            if(empty($full_name)) {
                $errors[] = 'Họ tên không được để trống';
            }

            if(empty($role_id)) {
                $errors[] = 'Vui lòng chọn vai trò';
            }

            if(empty($errors)) {
                $result = $this->user->createUser($username, $email, $password, $full_name, $role_id, $phone, $address);
                
                if($result) {
                    $_SESSION['success'] = 'Tạo tài khoản thành công!';
                    header('Location: index.php?controller=User&action=index');
                    exit();
                } else {
                    $errors[] = 'Có lỗi xảy ra khi tạo tài khoản';
                }
            }

            // Nếu có lỗi, hiển thị lại form
            $roles = $this->user->getAllRoles();
            require_once 'views/users/create_user.php';
        }
    }

    // Hiển thị thông tin chi tiết user
    public function show() {
        $user_id = (int)$_GET['id'];
        $user_data = $this->user->getUserWithRole($user_id);
        
        if(!$user_data) {
            $_SESSION['error'] = 'Không tìm thấy người dùng';
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        require_once 'views/users/show_user.php';
    }

    // Hiển thị form chỉnh sửa user
    public function edit() {
        $user_id = (int)$_GET['id'];
        $user_data = $this->user->getUserWithRole($user_id);
        
        if(!$user_data) {
            $_SESSION['error'] = 'Không tìm thấy người dùng';
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        $roles = $this->user->getAllRoles();
        require_once 'views/users/edit_user.php';
    }

    // Xử lý cập nhật user
    public function update() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = (int)$_POST['user_id'];
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $role_id = (int)$_POST['role_id'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            // Validation
            $errors = [];
            
            if(empty($username)) {
                $errors[] = 'Tên đăng nhập không được để trống';
            } elseif($this->user->usernameExists($username, $user_id)) {
                $errors[] = 'Tên đăng nhập đã tồn tại';
            }

            if(empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif($this->user->emailExists($email, $user_id)) {
                $errors[] = 'Email đã được sử dụng';
            }

            if(empty($full_name)) {
                $errors[] = 'Họ tên không được để trống';
            }

            if(empty($role_id)) {
                $errors[] = 'Vui lòng chọn vai trò';
            }

            // Cập nhật password nếu có
            $new_password = trim($_POST['new_password']);
            if(!empty($new_password) && strlen($new_password) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }

            if(empty($errors)) {
                $result = $this->user->updateUser($user_id, $username, $email, $full_name, $role_id, $phone, $address, $is_active, $new_password);
                
                if($result) {
                    $_SESSION['success'] = 'Cập nhật tài khoản thành công!';
                    header('Location: index.php?controller=User&action=index');
                    exit();
                } else {
                    $errors[] = 'Có lỗi xảy ra khi cập nhật tài khoản';
                }
            }

            // Nếu có lỗi, hiển thị lại form
            $user_data = $this->user->getUserWithRole($user_id);
            $roles = $this->user->getAllRoles();
            require_once 'views/users/edit_user.php';
        }
    }

    // Vô hiệu hóa user (thay vì xóa vĩnh viễn)
    public function delete() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = (int)$_POST['user_id'];
            
            // Không cho phép vô hiệu hóa chính mình
            if($user_id == $_SESSION['user_id']) {
                $_SESSION['error'] = 'Không thể vô hiệu hóa tài khoản của chính mình';
                header('Location: index.php?controller=User&action=index');
                exit();
            }

            // Vô hiệu hóa thay vì xóa vĩnh viễn
            $result = $this->user->disableUser($user_id);
            
            if($result) {
                $_SESSION['success'] = 'Vô hiệu hóa tài khoản thành công! (Có thể kích hoạt lại)';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi vô hiệu hóa tài khoản';
            }
        }

        header('Location: index.php?controller=User&action=index');
        exit();
    }

    // Kích hoạt/vô hiệu hóa user
    public function toggleStatus() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = (int)$_POST['user_id'];
            
            // Không cho phép vô hiệu hóa chính mình
            if($user_id == $_SESSION['user_id']) {
                $_SESSION['error'] = 'Không thể thay đổi trạng thái tài khoản của chính mình';
                header('Location: index.php?controller=User&action=index');
                exit();
            }

            $result = $this->user->toggleUserStatus($user_id);
            
            if($result) {
                $_SESSION['success'] = 'Thay đổi trạng thái tài khoản thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thay đổi trạng thái tài khoản';
            }
        }

        header('Location: index.php?controller=User&action=index');
        exit();
    }
}
?>
