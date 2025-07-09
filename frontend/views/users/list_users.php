<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="views/css/user-management.css" rel="stylesheet">
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
                            <a href="index.php?controller=User&action=index" class="nav-link text-white active">
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
                        <h2><i class="fas fa-users"></i> Quản lý tài khoản</h2>
                        <a href="index.php?controller=User&action=create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm tài khoản mới
                        </a>
                    </div>

                    <!-- Messages -->
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $_SESSION['success'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Users Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên đăng nhập</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Vai trò</th>
                                            <th>Số điện thoại</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($users)): ?>
                                            <tr>
                                                <td colspan="9" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach($users as $user): ?>
                                                <tr>
                                                    <td><?= $user['user_id'] ?></td>
                                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?= htmlspecialchars($user['role_name']) ?></span>
                                                    </td>
                                                    <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                                    <td>
                                                        <?php if($user['is_active']): ?>
                                                            <span class="badge bg-success">Hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Vô hiệu hóa</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="index.php?controller=User&action=show&id=<?= $user['user_id'] ?>" 
                                                               class="btn btn-info" title="Xem chi tiết">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="index.php?controller=User&action=edit&id=<?= $user['user_id'] ?>" 
                                                               class="btn btn-warning" title="Chỉnh sửa">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <?php if($user['user_id'] != $_SESSION['user_id']): ?>
                                                                <!-- Toggle Status -->
                                                                <form method="POST" action="index.php?controller=User&action=toggleStatus" class="d-inline">
                                                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                                                    <button type="submit" class="btn btn-secondary" 
                                                                            title="<?= $user['is_active'] ? 'Vô hiệu hóa' : 'Kích hoạt' ?>"
                                                                            onclick="return confirm('Bạn có chắc muốn thay đổi trạng thái tài khoản này?')">
                                                                        <i class="fas fa-<?= $user['is_active'] ? 'ban' : 'check' ?>"></i>
                                                                    </button>
                                                                </form>
                                                                
                                                                <!-- Delete -->
                                                                <form method="POST" action="index.php?controller=User&action=delete" class="d-inline">
                                                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                                                    <button type="submit" class="btn btn-danger" title="Xóa"
                                                                            onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="views/js/user-management.js"></script>
</body>
</html>
