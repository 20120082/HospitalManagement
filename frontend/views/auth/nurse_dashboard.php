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
    <title>Nurse Dashboard - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-nurse"></i> Nurse Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-nurse"></i> Xin chào, Y tá <?php echo $_SESSION['full_name']; ?>
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
                    <div class="card-header bg-warning text-white">
                        <h4><i class="fas fa-user-nurse"></i> Bảng điều khiển y tá</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Quản lý thuốc -->
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-pills fa-3x text-primary mb-3"></i>
                                        <h5>Quản lý thuốc</h5>
                                        <p>Kiểm tra và quản lý kho thuốc</p>
                                        <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-primary">Truy cập</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Xem đơn thuốc -->
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-prescription-bottle fa-3x text-success mb-3"></i>
                                        <h5>Xem đơn thuốc</h5>
                                        <p>Xem các đơn thuốc đã được kê</p>
                                        <a href="index.php?controller=Prescription&action=listPage" class="btn btn-success">Xem đơn thuốc</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Danh sách bệnh nhân -->
                            <div class="col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <i class="bi bi-people-fill fs-2 text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Bệnh nhân đang điều trị</h5>
                                        <p class="card-text">Xem danh sách bệnh nhân phụ trách</p>
                                        <a href="index.php?controller=Patient&action=list" class="btn btn-primary">Truy cập</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Bệnh án theo dõi -->
                            <div class="col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <i class="bi bi-journal-check fs-2 text-danger"></i>
                                        </div>
                                        <h5 class="card-title">Bệnh án</h5>
                                        <p class="card-text">Xem nội dung bệnh án để hỗ trợ điều trị</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>