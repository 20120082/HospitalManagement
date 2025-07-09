<?php
require_once 'config/database.php';
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $db = new Database();
        $this->user = new User($db->getConnection());
    }

    public function index()
    {
        require 'views/homepage.php';
    }

    public function login($username, $password) {
        $user = $this->user->authenticate($username, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['permissions'] = $user['permissions'];
            header('Location: index.php?controller=Auth&action=index');
            exit();
        } else {
            echo "Đăng nhập thất bại. Vui lòng kiểm tra tên đăng nhập hoặc mật khẩu.";
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }

}
?>