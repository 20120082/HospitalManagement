<?php
require_once 'views/layouts/header.php';
require_once 'models/MedicalRecord.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$backendPage = $page - 1;
$size = 10;

$response = MedicalRecord::getAllPaged($backendPage, $size);
$records = $response['content'] ?? [];
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

<div class="container mt-4">
    <h2>Danh sách bệnh án</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã bệnh án</th>
                    <th>Mã bệnh nhân</th>
                    <th>Mã phòng khám</th>
                    <th>Mã bác sĩ</th>
                    <th>Tên bác sĩ</th>
                    <th>Thời gian tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['recordId']) ?></td>
                            <td><?= htmlspecialchars($record['patientId']) ?></td>
                            <td><?= htmlspecialchars($record['roomId']) ?></td>
                            <td><?= htmlspecialchars($record['doctorId']) ?></td>
                            <td><?= htmlspecialchars($record['doctorName']) ?></td>
                            <td><?= htmlspecialchars($record['createdAt']) ?></td>
                            <td>
                                <a href="index.php?controller=MedicalRecord&action=viewPage&id=<?= urlencode($record['recordId']) ?>" class="btn btn-sm btn-info">Xem</a>
                                <a href="index.php?controller=MedicalRecord&action=updatePage&id=<?= urlencode($record['recordId']) ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?controller=MedicalRecord&action=delete&id=<?= urlencode($record['recordId']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có dữ liệu phòng khám.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PHÂN TRANG -->
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?controller=MedicalRecord&action=listPage&page=<?= $i ?>&size=<?= $size ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Quay về</a>
        <a href="index.php?controller=MedicalRecord&action=createPage" class="btn btn-primary">Thêm bệnh án mới</a>
    </div>
</div>

<?php include_once 'views/layouts/footer.php'; ?>