<?php
require_once 'views/layouts/header.php';
require_once 'models/Room.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$backendPage = $page - 1;
$size = 10;

$response = Room::getAllPaged($backendPage, $size);
$rooms = $response['content'] ?? [];
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
    <h2>Danh sách phòng khám</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã phòng</th>
                    <th>Tên phòng</th>
                    <th>Phòng ban</th>
                    <th>Bác sĩ phụ trách</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?= htmlspecialchars($room['roomId']) ?></td>
                            <td><?= htmlspecialchars($room['roomName']) ?></td>
                            <td><?= htmlspecialchars($room['department']) ?></td>
                            <td><?= htmlspecialchars($room['doctorName']) ?></td>
                            <td><?= $room['roomActive'] ? 'Hoạt động' : 'Ngưng hoạt động' ?></td>
                            <td>
                                <a href="index.php?controller=Room&action=viewPage&id=<?= urlencode($room['id']) ?>" class="btn btn-sm btn-info">Xem</a>
                                <a href="index.php?controller=Room&action=updatePage&id=<?= urlencode($room['id']) ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?controller=Room&action=delete&id=<?= urlencode($room['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
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
                    <a class="page-link" href="index.php?controller=Room&action=listPage&page=<?= $i ?>&size=<?= $size ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Quay về</a>
        <a href="index.php?controller=Room&action=createPage" class="btn btn-primary">Thêm phòng mới</a>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
