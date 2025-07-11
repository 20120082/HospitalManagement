<?php
$role = $_SESSION['role'] ?? '';
?>

<div class="container mt-4">
    <h2 class="mb-3">Chi tiết người bệnh</h2>

    <?php if (isset($patient)): ?>
        <table class="table table-bordered">
            <tr>
                <th>Mã bệnh nhân</th>
                <td><?= htmlspecialchars($patient->patientId) ?></td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td><?= htmlspecialchars($patient->fullName) ?></td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td><?= htmlspecialchars($patient->gender) ?></td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td><?= htmlspecialchars($patient->dateOfBirth) ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= htmlspecialchars($patient->phoneNumber) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($patient->email) ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?= htmlspecialchars($patient->address) ?></td>
            </tr>
            <tr>
                <th>Ngày tạo</th>
                <td><?= htmlspecialchars($patient->createdAt) ?></td>
            </tr>
        </table>

        <a href="index.php?controller=Patient&action=list" class="btn btn-secondary">Quay lại</a>

        <?php if (in_array($role, ['Admin', 'Receptionist'])): ?>
            <a href="index.php?controller=Patient&action=edit&id=<?= urlencode($patient->patientId) ?>" class="btn btn-warning">Sửa</a>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-danger">Không tìm thấy thông tin bệnh nhân.</div>
        <a href="index.php?controller=Patient&action=list" class="btn btn-secondary">Quay lại</a>
    <?php endif; ?>
</div>
