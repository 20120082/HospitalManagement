<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

$users = [
    ['username' => 'admin1', 'password' => 'admin123'],
    ['username' => 'doctor1', 'password' => 'doctor123'],
    ['username' => 'staff1', 'password' => 'staff123']
];

foreach ($users as $user) {
    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE Users SET password = :password WHERE username = :username");
    $stmt->execute(['password' => $hashed_password, 'username' => $user['username']]);
}

echo "Cập nhật mật khẩu thành công!";
?>