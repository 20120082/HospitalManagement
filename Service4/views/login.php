<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'login.php') {
    header('Location: /service4');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập - Service 4</title>
    <link rel="stylesheet" href="/service4/public/css/style.css">
</head>
<body>
    <form action="/service4/auth/login" method="POST">
        <h2>Đăng nhập</h2>
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
        <a href="/service4/register">Đăng ký</a>
    </form>
</body>
</html>