<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = 'users';

    public $user_id;
    public $username;
    public $email;
    public $password_hash;
    public $full_name;
    public $phone;
    public $address;
    public $role_id;
    public $is_active;
    public $last_login;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Đăng nhập
    public function login($username, $password) {
        $query = "SELECT u.*, r.role_name FROM " . $this->table . " u 
                  JOIN roles r ON u.role_id = r.role_id 
                  WHERE (u.username = :username OR u.email = :username) AND u.is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug - có thể xóa sau khi sửa xong
            error_log("Login attempt - Username: $username, Password: $password");
            error_log("Database hash: " . $row['password_hash']);
            error_log("Password verify result: " . (password_verify($password, $row['password_hash']) ? 'TRUE' : 'FALSE'));
            
            if(password_verify($password, $row['password_hash'])) {
                // Cập nhật last_login
                $this->updateLastLogin($row['user_id']);
                return $row;
            }
        }
        return false;
    }

    // Cập nhật thời gian đăng nhập cuối
    private function updateLastLogin($user_id) {
        $query = "UPDATE " . $this->table . " SET last_login = NOW() WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    // Lấy thông tin user theo ID
    public function getUserById($user_id) {
        $query = "SELECT u.*, r.role_name FROM " . $this->table . " u 
                  JOIN roles r ON u.role_id = r.role_id 
                  WHERE u.user_id = :user_id AND u.is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Lấy quyền của user
    public function getUserPermissions($user_id) {
        $query = "SELECT p.permission_name, p.module_name 
                  FROM users u
                  JOIN roles r ON u.role_id = r.role_id
                  JOIN role_permissions rp ON r.role_id = rp.role_id
                  JOIN permissions p ON rp.permission_id = p.permission_id
                  WHERE u.user_id = :user_id AND u.is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        $permissions = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[] = $row['permission_name'];
        }
        return $permissions;
    }

    // Kiểm tra quyền
    public function hasPermission($user_id, $permission) {
        $permissions = $this->getUserPermissions($user_id);
        return in_array($permission, $permissions);
    }

    // Ghi log đăng nhập
    public function logLoginAttempt($username, $ip_address, $success, $failure_reason = null) {
        $query = "INSERT INTO login_attempts (username, ip_address, success, failure_reason) 
                  VALUES (:username, :ip_address, :success, :failure_reason)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':success', $success);
        $stmt->bindParam(':failure_reason', $failure_reason);
        $stmt->execute();
    }

    // Tạo session
    public function createSession($user_id, $session_id) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        // Xóa session cũ của user này trước khi tạo session mới
        $this->destroyUserSessions($user_id);
        
        // Sử dụng INSERT ... ON DUPLICATE KEY UPDATE để xử lý trường hợp session_id đã tồn tại
        $query = "INSERT INTO user_sessions (session_id, user_id, ip_address, user_agent, login_time, last_activity, is_active) 
                  VALUES (:session_id, :user_id, :ip_address, :user_agent, NOW(), NOW(), 1)
                  ON DUPLICATE KEY UPDATE 
                  user_id = :user_id, 
                  ip_address = :ip_address, 
                  user_agent = :user_agent,
                  login_time = NOW(),
                  last_activity = NOW(),
                  is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':user_agent', $user_agent);
        $stmt->execute();
    }

    // Xóa tất cả session của user
    private function destroyUserSessions($user_id) {
        $query = "UPDATE user_sessions SET is_active = 0 WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    // Xóa session
    public function destroySession($session_id) {
        $query = "UPDATE user_sessions SET is_active = 0 WHERE session_id = :session_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
    }

    // Kiểm tra session hợp lệ
    public function validateSession($session_id) {
        $query = "SELECT user_id FROM user_sessions 
                  WHERE session_id = :session_id AND is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Lấy tất cả users
    public function getAllUsers() {
        $query = "SELECT u.*, r.role_name FROM " . $this->table . " u 
                  JOIN roles r ON u.role_id = r.role_id 
                  ORDER BY u.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả roles
    public function getAllRoles() {
        $query = "SELECT * FROM roles ORDER BY role_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra username đã tồn tại
    public function usernameExists($username, $exclude_user_id = null) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE username = :username";
        
        if($exclude_user_id) {
            $query .= " AND user_id != :exclude_user_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        
        if($exclude_user_id) {
            $stmt->bindParam(':exclude_user_id', $exclude_user_id);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email, $exclude_user_id = null) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE email = :email";
        
        if($exclude_user_id) {
            $query .= " AND user_id != :exclude_user_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if($exclude_user_id) {
            $stmt->bindParam(':exclude_user_id', $exclude_user_id);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Tạo user mới
    public function createUser($username, $email, $password, $full_name, $role_id, $phone = null, $address = null) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password_hash, full_name, role_id, phone, address, created_at) 
                  VALUES (:username, :email, :password_hash, :full_name, :role_id, :phone, :address, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        
        return $stmt->execute();
    }

    // Cập nhật user
    public function updateUser($user_id, $username, $email, $full_name, $role_id, $phone = null, $address = null, $is_active = 1, $new_password = null) {
        $query = "UPDATE " . $this->table . " 
                  SET username = :username, email = :email, full_name = :full_name, 
                      role_id = :role_id, phone = :phone, address = :address, is_active = :is_active";
        
        if(!empty($new_password)) {
            $query .= ", password_hash = :password_hash";
        }
        
        $query .= " WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':is_active', $is_active);
        $stmt->bindParam(':user_id', $user_id);
        
        if(!empty($new_password)) {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password_hash', $password_hash);
        }
        
        return $stmt->execute();
    }

    // Xóa user
    public function deleteUser($user_id) {
        // Xóa sessions của user trước
        $this->destroyUserSessions($user_id);
        
        // Xóa user
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    // Vô hiệu hóa user (thay vì xóa vĩnh viễn)
    public function disableUser($user_id) {
        // Vô hiệu hóa user và xóa sessions
        $this->destroyUserSessions($user_id);
        
        $query = "UPDATE " . $this->table . " 
                  SET is_active = 0, updated_at = NOW() 
                  WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    // Thay đổi trạng thái user (active/inactive)
    public function toggleUserStatus($user_id) {
        $query = "UPDATE " . $this->table . " 
                  SET is_active = NOT is_active 
                  WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    // Lấy user với thông tin role
    public function getUserWithRole($user_id) {
        $query = "SELECT u.*, r.role_name FROM " . $this->table . " u 
                  JOIN roles r ON u.role_id = r.role_id 
                  WHERE u.user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
