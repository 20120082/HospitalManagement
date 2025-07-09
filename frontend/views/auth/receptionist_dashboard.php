<?php
// Session đã được khởi động trong index.php
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=Auth&action=loginPage');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-tie"></i> Receptionist Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-tie"></i> Xin chào, <?php echo $_SESSION['full_name']; ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="index.php?controller=Auth&action=logout">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4><i class="fas fa-user-tie"></i> Bảng điều khiển lễ tân</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Quản lý lịch hẹn -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                                        <h5>Quản lý lịch hẹn</h5>
                                        <p>Đặt và quản lý lịch hẹn cho bệnh nhân</p>
                                        <a href="index.php?controller=Appointment&action=index" class="btn btn-primary">Truy cập</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin bệnh nhân -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-injured fa-3x text-success mb-3"></i>
                                        <h5>Thông tin bệnh nhân</h5>
                                        <p>Xem thông tin cơ bản của bệnh nhân</p>
                                        <a href="#" class="btn btn-success">Xem thông tin</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Quản lý thông báo -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                                        <h5>Quản lý thông báo</h5>
                                        <p>Gửi và quản lý thông báo</p>
                                        <a href="index.php?controller=Notification&action=index" class="btn btn-warning">Truy cập</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
