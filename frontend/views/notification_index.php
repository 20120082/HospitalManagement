<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-bell"></i> Quản lý thông báo</h2>
                    <div>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><i class="fas fa-list"></i></h4>
                                        <p class="card-text">Xem danh sách tất cả thông báo đã gửi</p>
                                    </div>
                                </div>
                                <a href="index.php?controller=Notification&action=listPage" class="btn btn-light">
                                    Xem danh sách <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><i class="fas fa-trash-alt"></i></h4>
                                        <p class="card-text">Xóa tất cả thông báo đã gửi</p>
                                    </div>
                                </div>
                                <button onclick="confirmDeleteAll()" class="btn btn-light">
                                    Xóa tất cả <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Hướng dẫn sử dụng</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Danh sách thông báo:</strong> Xem tất cả thông báo đã gửi, bao gồm thông báo lịch khám và đơn thuốc</li>
                            <li><strong>Xem chi tiết:</strong> Click vào nút "Xem" để xem nội dung chi tiết của thông báo</li>
                            <li><strong>Xóa thông báo:</strong> Click vào nút "Xóa" để xóa từng thông báo riêng lẻ</li>
                            <li><strong>Xóa tất cả:</strong> Sử dụng nút "Xóa tất cả" để xóa toàn bộ thông báo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDeleteAll() {
            if (confirm('Bạn có chắc chắn muốn xóa TẤT CẢ thông báo? Hành động này không thể hoàn tác!')) {
                window.location.href = 'index.php?controller=Notification&action=deleteAll';
            }
        }
    </script>
</body>
</html>
