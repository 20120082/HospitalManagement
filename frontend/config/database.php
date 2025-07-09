<?php
class Database {
    private $conn;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'service4_db';
        $user = 'root'; // Thay bằng tài khoản MySQL
        $pass = 'root'; // Thay bằng mật khẩu MySQL (để trống nếu chưa đặt)
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>