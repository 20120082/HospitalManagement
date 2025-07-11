<?php
// Session đã được khởi động trong index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=Auth&action=loginPage');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital"></i> Hospital Management
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-shield"></i> Xin chào, <?php echo $_SESSION['full_name']; ?>
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
                    <div class="card-header bg-primary text-white">
                        <h4><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Thống kê -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-users"></i> Tổng người dùng</h5>
                                        <h2>6</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-user-md"></i> Bác sĩ</h5>
                                        <h2>2</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-user-injured"></i> Bệnh nhân</h5>
                                        <h2>1</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5><i class="fas fa-user-nurse"></i> Y tá</h5>
                                        <h2>1</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-cogs"></i> Quản lý hệ thống</h5>
                                <div class="row">
                                    <!-- Quản lý người dùng -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                                <h5>Quản lý tài khoản</h5>
                                                <p>Thêm, sửa, xóa tài khoản người dùng</p>
                                                <a href="index.php?controller=User&action=index" class="btn btn-primary">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Báo cáo -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                                                <h5>Báo cáo</h5>
                                                <p>Xem các báo cáo thống kê</p>
                                                <a href="#" class="btn btn-success">Xem báo cáo</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cài đặt -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                                                <h5>Cài đặt hệ thống</h5>
                                                <p>Cấu hình các thông số hệ thống</p>
                                                <a href="#" class="btn btn-warning">Cài đặt</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-hospital"></i> Quản lý bệnh viện</h5>
                                <div class="row">
                                    <!-- Prescription Service -->
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-prescription-bottle fa-2x text-info mb-3"></i>
                                                <h6>Quản lý đơn thuốc</h6>
                                                <a href="index.php?controller=Prescription&action=index" class="btn btn-info btn-sm">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Doctor Service -->
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-user-md fa-2x text-success mb-3"></i>
                                                <h6>Quản lý bác sĩ</h6>
                                                <a href="index.php?controller=Doctor&action=index" class="btn btn-success btn-sm">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Medicine Service -->
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-pills fa-2x text-warning mb-3"></i>
                                                <h6>Quản lý thuốc</h6>
                                                <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-warning btn-sm">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Appointment Service -->
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-calendar-alt fa-2x text-danger mb-3"></i>
                                                <h6>Quản lý lịch hẹn</h6>
                                                <a href="index.php?controller=Appointment&action=index" class="btn btn-danger btn-sm">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Quản lý người bệnh -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <i class="bi bi-person-badge fs-2 text-primary"></i>
                                                </div>
                                                <h5 class="card-title">Quản lý người bệnh</h5>
                                                <p class="card-text">Thêm, sửa, xoá và tìm kiếm thông tin bệnh nhân</p>
                                                <a href="index.php?controller=Patient&action=listPage" class="btn btn-primary">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Quản lý phòng -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <i class="bi bi-hospital fs-2 text-success"></i>
                                                </div>
                                                <h5 class="card-title">Quản lý phòng</h5>
                                                <p class="card-text">Xem và chỉnh sửa thông tin các phòng</p>
                                                <a href="index.php?controller=Room&action=listPage" class="btn btn-success">Truy cập</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Quản lý bệnh án -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <i class="bi bi-journal-medical fs-2 text-danger"></i>
                                                </div>
                                                <h5 class="card-title">Quản lý bệnh án</h5>
                                                <p class="card-text">Xem, tạo và cập nhật bệnh án của bệnh nhân</p>
                                                <a href="index.php?controller=MedicalRecord&action=listPage" class="btn btn-danger">Truy cập</a>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>