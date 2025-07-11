<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Appointment List</h2>
        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient-ID Patient</th>
                    <th>Doctor Name</th>
                    <th>Room</th>
                    <th>Start Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No appointments found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                            <td>
                                <?php
                                    $patientName = '';
                                    $patientEmail = '';
                                    foreach ($patients as $patient) {
                                        if ($patient['patientId'] == $appointment['idPatient']) {
                                            $patientName = $patient['fullName'];
                                            $patientEmail = isset($patient['email']) ? $patient['email'] : '';
                                            break;
                                        }
                                    }
                                    echo htmlspecialchars($patientName) . '-' . htmlspecialchars($appointment['idPatient']);
                                ?>
                            </td>
                            <td><?php foreach ($doctors as $doctor): ?>
                                <?php if ($doctor['id'] == $appointment['idDoctor']): ?>
                                <?php echo htmlspecialchars($doctor['name']); ?>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?></td>
                            <td>
                                <?php
                                    $roomName = '';
                                    foreach ($rooms as $room) {
                                        if ($room['roomId'] == $appointment['idRoom']) {
                                            $roomName = $room['roomName'];
                                            break;
                                        }
                                    }
                                    echo htmlspecialchars($roomName);
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($appointment['startTime']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm send-appointment-notify-btn" 
                                    data-id="<?php echo htmlspecialchars($appointment['id']); ?>"
                                    data-patient-id="<?php echo htmlspecialchars($appointment['idPatient']); ?>"
                                    data-patient-name="<?php echo htmlspecialchars($patientName); ?>"
                                    data-patient-email="<?php echo htmlspecialchars($patientEmail); ?>"
                                    data-start-time="<?php echo htmlspecialchars($appointment['startTime']); ?>"
                                    data-room="<?php echo htmlspecialchars($roomName ?: 'Phòng khám'); ?>"
                                    data-doctor="<?php foreach ($doctors as $doctor) { if ($doctor['id'] == $appointment['idDoctor']) { echo htmlspecialchars($doctor['name']); break; } } ?>">
                                    Gửi thông báo
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Modal gửi thông báo lịch khám -->
<div class="modal fade" id="appointmentNotifyModal" tabindex="-1" aria-labelledby="appointmentNotifyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentNotifyModalLabel">Gửi thông báo lịch khám</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="appointmentNotifyForm">
          <input type="hidden" name="appointmentId" id="notifyAppointmentId">
          <div class="mb-2">
            <label>Email bệnh nhân:</label>
            <input type="email" name="to" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Tên bệnh nhân:</label>
            <input type="text" name="patientName" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Thời gian khám:</label>
            <input type="text" name="appointmentTime" class="form-control" id="notifyAppointmentTime" required readonly>
          </div>
          <div class="mb-2">
            <label>Phòng khám:</label>
            <input type="text" name="appointmentRoom" class="form-control" id="notifyAppointmentRoom" required readonly>
          </div>
          <div class="mb-2">
            <label>Bác sĩ:</label>
            <input type="text" name="appointmentDoctor" class="form-control" id="notifyAppointmentDoctor" required readonly>
          </div>
          <button type="submit" class="btn btn-success">Gửi thông báo</button>
        </form>
        <div id="appointmentNotifyResult" class="mt-2"></div>
      </div>
    </div>
  </div>
</div>
<a href="index.php?controller=Appointment" class="btn btn-primary">Back</a>
<script>
document.querySelectorAll('.send-appointment-notify-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('notifyAppointmentId').value = this.dataset.id;
        // Format thời gian cho dễ đọc
        const appointmentTime = this.dataset.startTime;
        const formattedTime = formatDateTime(appointmentTime);
        document.getElementById('notifyAppointmentTime').value = formattedTime;
        // Set room - luôn là tên phòng khám
        const roomValue = this.dataset.room;
        document.getElementById('notifyAppointmentRoom').value = roomValue || 'Phòng khám';
        document.getElementById('notifyAppointmentDoctor').value = this.dataset.doctor;
        // Tự động điền email và tên bệnh nhân
        document.querySelector('#appointmentNotifyForm [name="to"]').value = this.dataset.patientEmail || '';
        document.querySelector('#appointmentNotifyForm [name="patientName"]').value = this.dataset.patientName || '';
        document.getElementById('appointmentNotifyResult').textContent = '';
        var modal = new bootstrap.Modal(document.getElementById('appointmentNotifyModal'));
        modal.show();
    });
});

// Function để format datetime
function formatDateTime(dateTimeString) {
    try {
        const date = new Date(dateTimeString);
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        };
        return date.toLocaleString('vi-VN', options);
    } catch (e) {
        return dateTimeString; // Trả về giá trị gốc nếu không format được
    }
}

document.getElementById('appointmentNotifyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const resultDiv = document.getElementById('appointmentNotifyResult');
    
    // Hiển thị loading
    resultDiv.innerHTML = '<div class="alert alert-info">Đang gửi thông báo...</div>';
    
    try {
        const response = await fetch('index.php?controller=Appointment&action=sendAppointmentNotification', {
            method: 'POST',
            body: formData
        });
        
        // Kiểm tra content type
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            resultDiv.innerHTML = `<div class="alert alert-warning">Response không phải JSON. Vui lòng kiểm tra server.</div>`;
            return;
        }
        
        const result = await response.json();
        
        if(result.success) {
            resultDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
            // Tự động đóng modal sau 2 giây
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('appointmentNotifyModal')).hide();
            }, 2000);
        } else {
            resultDiv.innerHTML = `<div class="alert alert-danger">Lỗi: ${result.error || 'Không gửi được thông báo'}</div>`;
        }
    } catch (err) {
        resultDiv.innerHTML = `<div class="alert alert-danger">Lỗi kết nối tới server</div>`;
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>