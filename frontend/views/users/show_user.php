<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tài khoản - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark text-white min-vh-100">
                <div class="p-3">
                    <h5><i class="fas fa-hospital"></i> Hospital Management</h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="index.php?controller=Auth&action=adminDashboard" class="nav-link text-white">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?controller=User&action=index" class="nav-link text-white">
                                <i class="fas fa-users"></i> Quản lý tài khoản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?controller=Auth&action=logout" class="nav-link text-white">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-user"></i> Chi tiết tài khoản: <?= htmlspecialchars($user_data['username']) ?></h2>
                        <div>
                            <a href="index.php?controller=User&action=edit&id=<?= $user_data['user_id'] ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            <a href="index.php?controller=User&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Thông tin cơ bản -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-info-circle"></i> Thông tin cơ bản</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">ID:</td>
                                                    <td><?= $user_data['user_id'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Tên đăng nhập:</td>
                                                    <td><?= htmlspecialchars($user_data['username']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Họ tên:</td>
                                                    <td><?= htmlspecialchars($user_data['full_name']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Email:</td>
                                                    <td><?= htmlspecialchars($user_data['email']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Số điện thoại:</td>
                                                    <td><?= htmlspecialchars($user_data['phone'] ?? 'Chưa cập nhật') ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Vai trò:</td>
                                                    <td>
                                                        <span class="badge bg-info fs-6"><?= htmlspecialchars($user_data['role_name']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Trạng thái:</td>
                                                    <td>
                                                        <?php if($user_data['is_active']): ?>
                                                            <span class="badge bg-success fs-6">Hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger fs-6">Vô hiệu hóa</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Ngày tạo:</td>
                                                    <td><?= date('d/m/Y H:i', strtotime($user_data['created_at'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Đăng nhập cuối:</td>
                                                    <td>
                                                        <?php if($user_data['last_login']): ?>
                                                            <?= date('d/m/Y H:i', strtotime($user_data['last_login'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Chưa đăng nhập</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <?php if($user_data['address']): ?>
                                        <hr>
                                        <div class="mb-0">
                                            <strong>Địa chỉ:</strong><br>
                                            <?= nl2br(htmlspecialchars($user_data['address'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin phụ -->
                        <div class="col-md-4">
                            <!-- Avatar -->
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                                    </div>
                                    <h5><?= htmlspecialchars($user_data['full_name']) ?></h5>
                                    <p class="text-muted"><?= htmlspecialchars($user_data['role_name']) ?></p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h6><i class="fas fa-tools"></i> Thao tác</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="index.php?controller=User&action=edit&id=<?= $user_data['user_id'] ?>" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Chỉnh sửa
                                        </a>
                                        
                                        <?php if($user_data['user_id'] != $_SESSION['user_id']): ?>
                                            <!-- Toggle Status -->
                                            <form method="POST" action="index.php?controller=User&action=toggleStatus">
                                                <input type="hidden" name="user_id" value="<?= $user_data['user_id'] ?>">
                                                <button type="submit" class="btn btn-<?= $user_data['is_active'] ? 'secondary' : 'success' ?> w-100"
                                                        onclick="return confirm('Bạn có chắc muốn thay đổi trạng thái tài khoản này?')">
                                                    <i class="fas fa-<?= $user_data['is_active'] ? 'ban' : 'check' ?>"></i> 
                                                    <?= $user_data['is_active'] ? 'Vô hiệu hóa' : 'Kích hoạt' ?>
                                                </button>
                                            </form>

                                            <!-- Delete -->
                                            <form method="POST" action="index.php?controller=User&action=delete">
                                                <input type="hidden" name="user_id" value="<?= $user_data['user_id'] ?>">
                                                <button type="submit" class="btn btn-danger w-100"
                                                        onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?\nThao tác này không thể hoàn tác!')">
                                                    <i class="fas fa-trash"></i> Xóa tài khoản
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="card mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6><i class="fas fa-chart-bar"></i> Thống kê</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-primary"><?= rand(0, 50) ?></h4>
                                            <small class="text-muted">Hoạt động</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-success"><?= rand(1, 30) ?></h4>
                                            <small class="text-muted">Ngày hoạt động</small>
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
