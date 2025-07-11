<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Prescription List</h2>
        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient-Patient ID</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($prescriptions)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No prescriptions found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prescription['id']); ?></td>
                            <td><?php foreach ($patients as $patient): ?>
                                <?php if ($patient['patientId'] == $prescription['idPatient']): ?>
                                <?php echo htmlspecialchars($patient['fullName']); ?> - <?php echo $prescription['idPatient']; ?>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?></td>
                            <td><?php echo htmlspecialchars($prescription['createdDate']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['status']); ?></td>
                            <td>
                                <a href="index.php?controller=Prescription&action=viewDetails&id=<?php echo $prescription['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="index.php?controller=Prescription" class="btn btn-primary">Back</a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        document.querySelectorAll('.btn-send-notify').forEach(function(btn) {
            btn.addEventListener('click', async function() {
                const patientId = this.getAttribute('data-patient-id');
                const prescriptionId = this.getAttribute('data-prescription-id');
                // Gọi AJAX lấy thông tin bệnh nhân và đơn thuốc
                try {
                    const res = await fetch(`index.php?controller=Prescription&action=GetPatientAndPrescriptionInfo&idPatient=${patientId}&idPrescription=${prescriptionId}`);
                    const info = await res.json();
                    if (!info.success) {
                        alert('Không lấy được thông tin bệnh nhân hoặc đơn thuốc!');
                        return;
                    }
                    // Gửi thông báo
                    const notifyRes = await fetch('controllers/PrescriptionNotificationController.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            to: info.email,
                            patientName: info.name,
                            prescriptionDetail: info.prescriptionDetail,
                            prescriptionTime: info.prescriptionTime
                        })
                    });
                    const notifyResult = await notifyRes.json();
                    if (notifyResult.success) {
                        alert('Đã gửi thông báo đơn thuốc thành công!');
                    } else {
                        alert('Lỗi gửi thông báo: ' + (notifyResult.error || 'Không gửi được thông báo'));
                    }
                } catch (e) {
                    alert('Lỗi kết nối hoặc xử lý!');
                }
            });
        });
        </script>
</body>
    
        