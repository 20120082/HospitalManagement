<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-bell"></i> Danh sách thông báo</h2>
                    <div>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                        <a href="index.php?controller=Notification&action=index" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button onclick="window.location.reload()" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Làm mới
                        </button>
                        <button onclick="confirmDeleteAll()" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Xóa tất cả
                        </button>
                    </div>
                </div>

                <!-- Phần lọc thông báo -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-filter"></i> Bộ lọc thông báo</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label for="typeFilter" class="form-label">Lọc theo loại:</label>
                                <select id="typeFilter" class="form-select">
                                    <option value="">Tất cả loại</option>
                                    <option value="appointment">Lịch khám</option>
                                    <option value="prescription">Đơn thuốc</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="statusFilter" class="form-label">Lọc theo trạng thái:</label>
                                <select id="statusFilter" class="form-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="success">Thành công</option>
                                    <option value="failed">Thất bại</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="patientFilter" class="form-label">Tìm kiếm bệnh nhân:</label>
                                <input type="text" id="patientFilter" class="form-control" placeholder="Nhập tên bệnh nhân để tìm kiếm...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                        <i class="fas fa-times"></i> Xóa bộ lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách thông báo đã gửi</h5>
                        <span id="notificationCount" class="badge bg-primary"><?php echo count($notifications); ?> thông báo</span>
                    </div>
                    <div class="card-body">
                        <?php if (empty($notifications)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="h5">Chưa có thông báo nào được gửi</p>
                                <p>Các thông báo từ hệ thống sẽ được hiển thị tại đây</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="notificationsTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên bệnh nhân</th>
                                            <th>Tiêu đề</th>
                                            <th>Loại</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="notificationsTableBody">
                                        <?php foreach ($notifications as $index => $notification): ?>
                                            <?php $date = new DateTime($notification['createdAt']); ?>
                                            <tr data-type="<?php echo $notification['type']; ?>" 
                                                data-status="<?php echo $notification['status']; ?>" 
                                                data-email="<?php echo strtolower($notification['to']); ?>"
                                                data-text="<?php echo strtolower(htmlspecialchars($notification['text'])); ?>"
                                                data-notification-id="<?php echo htmlspecialchars($notification['_id']); ?>"
                                                data-notification-subject="<?php echo htmlspecialchars($notification['subject']); ?>"
                                                data-notification-content="<?php echo htmlspecialchars($notification['text']); ?>"
                                                data-notification-time="<?php echo $date->format('d/m/Y H:i:s'); ?>"
                                                data-patient-name="<?php echo strtolower($notification['patientName']); ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo htmlspecialchars($notification['patientName']); ?></td>
                                                <td><?php echo htmlspecialchars($notification['subject']); ?></td>
                                                <td>
                                                    <?php if ($notification['type'] === 'appointment'): ?>
                                                        <span class="badge bg-info">Lịch khám</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Đơn thuốc</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($notification['status'] === 'success'): ?>
                                                        <span class="badge bg-success">Thành công</span>
                                                    <?php elseif ($notification['status'] === 'failed'): ?>
                                                        <span class="badge bg-danger">Thất bại</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Không xác định</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    echo $date->format('d/m/Y H:i:s'); 
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="viewDetailFromRow(this)">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            onclick="deleteNotification('<?php echo htmlspecialchars($notification['_id']); ?>')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xem chi tiết -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="notificationDetail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Biến toàn cục để lưu trạng thái lọc
        let allRows = [];
        
        // Khởi tạo khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            initializeFilters();
        });
        
        // Khởi tạo bộ lọc
        function initializeFilters() {
            const tableBody = document.getElementById('notificationsTableBody');
            if (tableBody) {
                allRows = Array.from(tableBody.querySelectorAll('tr'));
                
                // Thêm event listener cho các bộ lọc
                document.getElementById('typeFilter').addEventListener('change', applyFilters);
                document.getElementById('statusFilter').addEventListener('change', applyFilters);
                document.getElementById('patientFilter').addEventListener('input', applyFilters);
            }
        }
        
        // Áp dụng bộ lọc
        function applyFilters() {
            const typeFilter = document.getElementById('typeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const patientFilter = document.getElementById('patientFilter').value.toLowerCase();
            
            let visibleCount = 0;
            
            allRows.forEach(function(row, index) {
                let isVisible = true;
                
                // Lọc theo loại
                if (typeFilter && row.dataset.type !== typeFilter) {
                    isVisible = false;
                }
                
                // Lọc theo trạng thái
                if (statusFilter && row.dataset.status !== statusFilter) {
                    isVisible = false;
                }
                
                // Lọc theo tên bệnh nhân (tìm trong data-patient-name)
                if (patientFilter && !row.dataset.patientName.includes(patientFilter)) {
                    isVisible = false;
                }
                
                if (isVisible) {
                    row.style.display = '';
                    visibleCount++;
                    // Cập nhật số thứ tự
                    row.querySelector('td:first-child').textContent = visibleCount;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Cập nhật số lượng thông báo hiển thị
            updateNotificationCount(visibleCount);
            
            // Hiển thị thông báo nếu không có kết quả
            showNoResultsMessage(visibleCount === 0);
        }
        
        // Cập nhật số lượng thông báo
        function updateNotificationCount(count) {
            const countElement = document.getElementById('notificationCount');
            if (countElement) {
                countElement.textContent = count + ' thông báo';
            }
        }
        
        // Hiển thị thông báo không có kết quả
        function showNoResultsMessage(show) {
            let noResultsRow = document.getElementById('noResultsRow');
            
            if (show) {
                if (!noResultsRow) {
                    const tableBody = document.getElementById('notificationsTableBody');
                    noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResultsRow';
                    noResultsRow.innerHTML = `
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <p class="h6">Không tìm thấy thông báo nào phù hợp với bộ lọc</p>
                            <p class="small">Thử điều chỉnh các tiêu chí lọc hoặc xóa bộ lọc để xem tất cả</p>
                        </td>
                    `;
                    tableBody.appendChild(noResultsRow);
                }
                noResultsRow.style.display = '';
            } else if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        }
        
        // Xóa bộ lọc
        function clearFilters() {
            document.getElementById('typeFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('patientFilter').value = '';
            applyFilters();
        }

        // Xem chi tiết thông báo từ data attributes
        function viewDetailFromRow(button) {
            const row = button.closest('tr');
            const id = row.getAttribute('data-notification-id');
            const subject = row.getAttribute('data-notification-subject');
            const text = row.getAttribute('data-notification-content');
            const createdAt = row.getAttribute('data-notification-time');
            const email = row.getAttribute('data-email');
            
            viewDetail(id, subject, text, createdAt, email);
        }

        // Xem chi tiết thông báo
        function viewDetail(id, subject, text, createdAt, email) {
            const detailContent = `
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email bệnh nhân:</strong></div>
                    <div class="col-md-9"><code>${email}</code></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Tiêu đề:</strong></div>
                    <div class="col-md-9">${subject}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Thời gian:</strong></div>
                    <div class="col-md-9">${createdAt}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Nội dung:</strong></div>
                    <div class="col-md-9">
                        <div style="white-space: pre-wrap; background-color: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #007bff;">
                            ${text}
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('notificationDetail').innerHTML = detailContent;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }

        // Xóa một thông báo
        function deleteNotification(id) {
            if (confirm('Bạn có chắc chắn muốn xóa thông báo này?')) {
                // Tạo form và submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php?controller=Notification&action=delete';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Xóa tất cả thông báo
        function confirmDeleteAll() {
            if (confirm('Bạn có chắc chắn muốn xóa TẤT CẢ thông báo? Hành động này không thể hoàn tác!')) {
                window.location.href = 'index.php?controller=Notification&action=deleteAll';
            }
        }
    </script>
</body>
</html>
