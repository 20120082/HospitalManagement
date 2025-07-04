<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Prescription Notification</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <h1>Gửi thông báo đơn thuốc</h1>
    <a href="index.php?controller=Prescription" class="btn btn-primary" style="margin-bottom: 20px;">Back</a>
    <form id="prescriptionNotifyForm" method="POST" action="controllers/PrescriptionNotificationController.php">
        <label>Email bệnh nhân:
            <input type="email" name="to" required>
        </label><br><br>
        <label>Tên bệnh nhân:
            <input type="text" name="patientName" required>
        </label><br><br>
        <label>Chi tiết đơn thuốc:
            <input type="text" name="prescriptionDetail" required>
        </label><br><br>
        <label>Thời gian lấy thuốc:
            <input type="text" name="prescriptionTime" required placeholder="VD: 10:00 04/07/2025">
        </label><br><br>
        <button type="submit">Gửi thông báo</button>
    </form>
    <div id="result"></div>
    <script>
    document.getElementById('prescriptionNotifyForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        document.getElementById('result').textContent = 'Đang gửi...';
        try {
            const response = await fetch('controllers/PrescriptionNotificationController.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if(result.success) {
                document.getElementById('result').textContent = result.message;
            } else {
                document.getElementById('result').textContent = 'Lỗi: ' + (result.error || 'Không gửi được thông báo');
            }
        } catch (err) {
            document.getElementById('result').textContent = 'Lỗi kết nối tới Notification Service!';
        }
    });
    </script>
</body>
</html>
