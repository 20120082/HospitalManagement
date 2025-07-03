<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();
echo "Kết nối database thành công!";
?>