<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Prescription Details</h2>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Prescription ID: <?php echo htmlspecialchars($prescription['id']); ?></h5>
                <p class="card-text"><strong>Patient ID:</strong> <?php echo htmlspecialchars($prescription['idPatient']); ?></p>
                <p class="card-text"><strong>Created Date:</strong> <?php echo htmlspecialchars($prescription['createdDate']); ?></p>
                <p class="card-text"><strong>Status:</strong> <?php echo htmlspecialchars($prescription['status']); ?></p>
            </div>
        </div>
        <h4>Prescription Details</h4>
        <?php
        $totalAmount = 0;
        if (!empty($prescription['details'])) {
            foreach ($prescription['details'] as $d0) {
                $totalAmount += $d0['price'] * $d0['quantity'];
            }
        }
        ?>
        <?php if (empty($prescription['details'])): ?>
            <p>No details available for this prescription.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Detail ID</th>
                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $d1): ?>
                        <tr>
                            <td><?php echo ($d1['id']); ?></td>
                            <td><?php echo ($d1['medicineName'] ?? 'Unknown (ID: ' . $d1['idMedicine'] . ')'); ?></td>
                            <td><?php echo ($d1['quantity']); ?></td>
                            <td><?php echo ($d1['unit']); ?></td>
                            <td><?php echo (number_format($d1['price'], 2)); ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="fw-bold total-amount">Tổng số tiền: <?php echo htmlspecialchars(number_format($totalAmount, 2)); ?> VND</p>
        <?php endif; ?>
        <form id="sendNotifyForm" method="POST" action="controllers/PrescriptionNotificationController.php" class="mb-3">
            <div class="mb-2">
                <label>Email bệnh nhân:</label>
                <input type="email" name="to" class="form-control" required value="<?php echo htmlspecialchars($patient['email'] ?? ''); ?>">
            </div>
            <div class="mb-2">
                <label>Tên bệnh nhân:</label>
                <input type="text" name="patientName" class="form-control" required value="<?php echo htmlspecialchars($patient['name'] ?? ''); ?>">
            </div>
            <div class="mb-2">
                <label>Chi tiết đơn thuốc:</label>
                <textarea name="prescriptionDetail" class="form-control" rows="2" required><?php
                    $detailLines = [];
                    $totalAmount = 0;
                    if (!empty($details)) {
                        foreach ($details as $d1) {
                            $line = ($d1['medicineName'] ?? ('ID:' . $d1['idMedicine'])) . ' x' . $d1['quantity'] . ' (' . number_format($d1['price'] * $d1['quantity'], 2) . ' VND)';
                            $detailLines[] = $line;
                            $totalAmount += $d1['price'] * $d1['quantity'];
                        }
                    }
                    $prescriptionText = implode(', ', $detailLines);
                    // Xóa dấu phẩy cuối cùng nếu có, rồi xuống dòng tổng giá tiền
                    $prescriptionText .= "\nTổng giá tiền: " . number_format($totalAmount, 2) . " VND";
                    echo htmlspecialchars($prescriptionText);
                ?></textarea>
            </div>
            <div class="mb-2">
                <label>Thời gian lấy thuốc:</label>
                <input type="text" name="prescriptionTime" class="form-control" required placeholder="Nhập thời gian lấy thuốc">
            </div>
            <button type="submit" class="btn btn-success">Gửi thông báo đơn thuốc</button>
        </form>
        <div id="notifyResult"></div>
        <a href="index.php?controller=Prescription&action=ListPage" class="btn btn-primary">Back</a>
        <script>
        document.getElementById('sendNotifyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            document.getElementById('notifyResult').textContent = 'Đang gửi...';
            try {
                const response = await fetch('controllers/PrescriptionNotificationController.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if(result.success) {
                    document.getElementById('notifyResult').textContent = result.message;
                } else {
                    document.getElementById('notifyResult').textContent = 'Lỗi: ' + (result.error || 'Không gửi được thông báo');
                }
            } catch (err) {
                document.getElementById('notifyResult').textContent = 'Lỗi kết nối tới Notification Service!';
            }
        });
        </script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>