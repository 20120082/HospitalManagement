<?php
require_once 'views/layouts/header.php';
require_once 'models/Patient.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$backendPage = $page - 1;
$size = 10;

$response = Patient::getAllPaged($backendPage, $size);
$patients = $response['content'] ?? [];
$totalPages = $response['totalPages'] ?? 1;

$role = $_SESSION['role'] ?? 'guest'; // fallback nếu không đăng nhập
$dashboardLink = match ($role) {
    'admin' => 'index.php?controller=Auth&action=adminDashboard',
    'doctor' => 'doctor_dashboard.php',
    'nurse' => 'nurse_dashboard.php',
    'receptionist' => 'receptionist_dashboard.php',
    default => 'index.php'
};
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php elseif (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<div class="mb-3">
    <a href="index.php?controller=Patient&action=create" class="btn btn-success">➕ Thêm bệnh nhân</a>
    <a href="index.php?controller=Patient&action=search" class="btn btn-secondary">🔍 Tìm kiếm</a>
    <a href="index.php?controller=Patient&action=countByMonth&year=2025&month=7" class="btn btn-info">📊 Thống kê</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Mã BN</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?= htmlspecialchars($patient['patientId']) ?></td>
                <td><?= htmlspecialchars($patient['fullName']) ?></td>
                <td><?= htmlspecialchars($patient['gender']) ?></td>
                <td><?= htmlspecialchars($patient['dateOfBirth']) ?></td>
                <td><?= htmlspecialchars($patient['phoneNumber']) ?></td>
                <td><?= htmlspecialchars($patient['email']) ?></td>
                <td><?= htmlspecialchars($patient['address']) ?></td>
                <td>
                    <a href="index.php?controller=Patient&action=viewPage&id=<?= $patient['patientId'] ?>" class="btn btn-sm btn-primary">Xem</a>
                    <a href="index.php?controller=Patient&action=editPage&id=<?= $patient['patientId'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="index.php?controller=Patient&action=delete&id=<?= $patient['patientId'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bệnh nhân này?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- PHÂN TRANG -->
<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="index.php?controller=Patient&action=listPage&page=<?= $i ?>&size=<?= $size ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<div><a href="<?= $dashboardLink ?>" class="btn btn-secondary mb-3">← Quay về trang chính</a></div>

<?php require_once 'views/layouts/footer.php'; ?>