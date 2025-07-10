<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không có quyền truy cập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-lock fa-5x text-danger mb-4"></i>
                        <h3 class="text-danger">Không có quyền truy cập</h3>
                        <p class="text-muted">Bạn không có quyền truy cập vào trang này.</p>
                        <a href="javascript:history.back()" class="btn btn-primary">Quay lại</a>
                        <a href="index.php?controller=Auth&action=logout" class="btn btn-secondary">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
