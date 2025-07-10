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
    <title>Doctor Dashboard - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-md"></i> Doctor Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-md"></i> Xin chào, Bác sĩ <?php echo $_SESSION['full_name']; ?>
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
                    <div class="card-header bg-success text-white">
                        <h4><i class="fas fa-stethoscope"></i> Bảng điều khiển bác sĩ</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Thống kê nhanh -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-calendar-check"></i> Lịch hẹn hôm nay</h5>
                                        <h2>8</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-prescription-bottle"></i> Đơn thuốc</h5>
                                        <h2>15</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-user-injured"></i> Bệnh nhân</h5>
                                        <h2>32</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-clock"></i> Chờ khám</h5>
                                        <h2>5</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-tasks"></i> Công việc hằng ngày</h5>
                                <div class="row">
                                    <!-- Quản lý lịch hẹn -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                                                <h5>Quản lý lịch hẹn</h5>
                                                <p>Xem và quản lý lịch hẹn của bệnh nhân</p>
                                                <a href="index.php?controller=Appointment&action=index" class="btn btn-primary">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quản lý đơn thuốc -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-prescription-bottle fa-3x text-success mb-3"></i>
                                                <h5>Quản lý đơn thuốc</h5>
                                                <p>Tạo và quản lý đơn thuốc cho bệnh nhân</p>
                                                <a href="index.php?controller=Prescription&action=index" class="btn btn-success">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Danh sách thuốc -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-pills fa-3x text-warning mb-3"></i>
                                                <h5>Danh sách thuốc</h5>
                                                <p>Xem danh sách các loại thuốc có sẵn</p>
                                                <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-warning">Xem thuốc</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5><i class="fas fa-clock"></i> Lịch hẹn hôm nay</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <strong>09:00 - 09:30</strong><br>
                                                <small>Nguyễn Văn A - Khám tổng quát</small>
                                            </div>
                                            <div class="list-group-item">
                                                <strong>10:00 - 10:30</strong><br>
                                                <small>Trần Thị B - Tái khám</small>
                                            </div>
                                            <div class="list-group-item">
                                                <strong>11:00 - 11:30</strong><br>
                                                <small>Lê Văn C - Khám chuyên khoa</small>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="index.php?controller=Appointment&action=index" class="btn btn-info btn-sm">Xem tất cả</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        <h5><i class="fas fa-prescription-bottle"></i> Đơn thuốc gần đây</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <strong>Đơn thuốc #001</strong><br>
                                                <small>Bệnh nhân: Nguyễn Văn A - Hôm nay</small>
                                            </div>
                                            <div class="list-group-item">
                                                <strong>Đơn thuốc #002</strong><br>
                                                <small>Bệnh nhân: Trần Thị B - Hôm qua</small>
                                            </div>
                                            <div class="list-group-item">
                                                <strong>Đơn thuốc #003</strong><br>
                                                <small>Bệnh nhân: Lê Văn C - 2 ngày trước</small>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="index.php?controller=Prescription&action=index" class="btn btn-warning btn-sm">Xem tất cả</a>
                                        </div>
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
