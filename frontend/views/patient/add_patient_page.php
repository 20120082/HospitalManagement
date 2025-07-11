<?php include_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Tạo Bệnh Nhân Mới</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="index.php?controller=Patient&action=create" method="POST" class="shadow p-4 rounded bg-light">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fullName" class="form-label">Họ tên bệnh nhân</label>
                <input type="text" class="form-control" name="fullName"
                    value="<?php echo isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : ''; ?>" required>
            </div>

            <div class="col-md-6">
                <label for="gender" class="form-label">Giới tính</label>
                <select class="form-select" name="gender" required>
                    <option value="">-- Chọn giới tính --</option>
                    <option value="Nam" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dateOfBirth" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" name="dateOfBirth"
                    value="<?php echo isset($_POST['dateOfBirth']) ? htmlspecialchars($_POST['dateOfBirth']) : ''; ?>" required>
            </div>

            <div class="col-md-6">
                <label for="phoneNumber" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="phoneNumber"
                    value="<?php echo isset($_POST['phoneNumber']) ? htmlspecialchars($_POST['phoneNumber']) : ''; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="col-md-6">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" name="address"
                    value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">Tạo bệnh nhân</button>
            <a href="index.php?controller=Patient&action=listPage" class="btn btn-secondary px-4">Hủy</a>
        </div>
    </form>
</div>

<?php include_once 'views/layouts/footer.php'; ?>