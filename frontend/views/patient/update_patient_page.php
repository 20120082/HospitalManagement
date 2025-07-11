<?php
$role = $_SESSION['role'] ?? '';

// Bảo vệ: chỉ Admin và Receptionist mới được sửa
if (!in_array($role, ['Admin', 'Receptionist'])) {
    echo "<div class='alert alert-danger'>Bạn không có quyền truy cập trang này.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-3">Cập nhật thông tin người bệnh</h2>

    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $field => $msg): ?>
                    <li><strong><?= htmlspecialchars($field) ?>:</strong> <?= htmlspecialchars($msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=Patient&action=update">
        <!-- Hidden field để gửi mã bệnh nhân -->
        <input type="hidden" name="patientId" value="<?= htmlspecialchars($patient->patientId) ?>">

        <div class="mb-3">
            <label for="fullName" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="fullName" name="fullName" required value="<?= htmlspecialchars($patient->fullName) ?>">
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">-- Chọn --</option>
                <option value="Nam" <?= $patient->gender === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $patient->gender === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="dateOfBirth" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required value="<?= htmlspecialchars($patient->dateOfBirth) ?>">
        </div>

        <div class="mb-3">
            <label for="phoneNumber" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?= htmlspecialchars($patient->phoneNumber) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($patient->email) ?>">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="2"><?= htmlspecialchars($patient->address) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php?controller=Patient&action=list" class="btn btn-secondary">Huỷ</a>
    </form>
</div>
