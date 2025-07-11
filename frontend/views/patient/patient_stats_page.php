<?php
$role = $_SESSION['role'] ?? '';
$year = $_GET['year'] ?? date('Y');

// Chỉ Admin mới được xem thống kê
if ($role !== 'Admin') {
    echo "<div class='alert alert-danger'>Bạn không có quyền truy cập trang này.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-3">Thống kê bệnh nhân theo tháng (<?= htmlspecialchars($year) ?>)</h2>

    <?php if (isset($stats) && is_array($stats)): ?>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>Tháng</th>
                    <th>Số lượng bệnh nhân</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats as $month => $count): ?>
                    <tr>
                        <td><?= htmlspecialchars($month) ?></td>
                        <td><?= htmlspecialchars($count) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Không có dữ liệu thống kê.</div>
    <?php endif; ?>

    <a href="index.php?controller=Patient&action=list" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
