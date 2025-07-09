<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản - Hospital Management</title>
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
                        <h2><i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản: <?= htmlspecialchars($user_data['username']) ?></h2>
                        <a href="index.php?controller=User&action=index" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <!-- Error Messages -->
                    <?php if(!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Edit User Form -->
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="index.php?controller=User&action=update">
                                <input type="hidden" name="user_id" value="<?= $user_data['user_id'] ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?= htmlspecialchars($user_data['username']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= htmlspecialchars($user_data['email']) ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                                   value="<?= htmlspecialchars($user_data['full_name']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Vai trò <span class="text-danger">*</span></label>
                                            <select class="form-select" id="role_id" name="role_id" required>
                                                <option value="">Chọn vai trò</option>
                                                <?php foreach($roles as $role): ?>
                                                    <option value="<?= $role['role_id'] ?>" 
                                                            <?= ($user_data['role_id'] == $role['role_id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($role['role_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone" name="phone" 
                                                   value="<?= htmlspecialchars($user_data['phone'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6">
                                            <div class="form-text">Để trống nếu không muốn thay đổi mật khẩu</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($user_data['address'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               <?= $user_data['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            Tài khoản hoạt động
                                        </label>
                                    </div>
                                </div>

                                <!-- Thông tin bổ sung -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ngày tạo</label>
                                            <input type="text" class="form-control" 
                                                   value="<?= date('d/m/Y H:i', strtotime($user_data['created_at'])) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Đăng nhập cuối</label>
                                            <input type="text" class="form-control" 
                                                   value="<?= $user_data['last_login'] ? date('d/m/Y H:i', strtotime($user_data['last_login'])) : 'Chưa đăng nhập' ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="index.php?controller=User&action=show&id=<?= $user_data['user_id'] ?>" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                    <a href="index.php?controller=User&action=index" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
