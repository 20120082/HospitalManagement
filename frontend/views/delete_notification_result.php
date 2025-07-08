<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả xóa thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><i class="fas fa-info-circle"></i> Kết quả thao tác</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php if (strpos($message, 'thành công') !== false): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h5><?php echo htmlspecialchars($message); ?></h5>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                <h5><?php echo htmlspecialchars($message); ?></h5>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="index.php?controller=Notification&action=listPage" class="btn btn-primary">
                                <i class="fas fa-list"></i> Quay lại danh sách
                            </a>
                            <a href="index.php?controller=Notification&action=index" class="btn btn-secondary">
                                <i class="fas fa-bell"></i> Quản lý thông báo
                            </a>
                            <a href="index.php" class="btn btn-info">
                                <i class="fas fa-home"></i> Trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
