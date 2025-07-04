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
    <h2>Create Appointment</h2>
        <form action="index.php?controller=Appointment&action=create" method="POST" class="mb-5">
            <div class="mb-3">
                <label for="idPatient" class="form-label">Patient ID</label>
                <input type="number" class="form-control" id="idPatient" name="idPatient" required>
            </div>
            <div class="mb-3">
                <label for="idDoctor" class="form-label">Doctor</label>
                <select class="form-select" name="idDoctor" required>
                    <option value="">Select a Doctor</option>
                        <?php
                            foreach ($doctors as $doctor) {
                                echo "<option value='{$doctor['id']}'>{$doctor['name']}</option>";
                                }
                        ?>
                    </select>
            </div>
            <div class="mb-3">
                <label for="idRoom" class="form-label">Room ID</label>
                <input type="number" class="form-control" id="idRoom" name="idRoom" required>
            </div>
            <div class="mb-3">
                <label for="startTime" class="form-label">Start Time</label>
                <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Chưa khám">Chưa khám</option>
                    <option value="Đã khám">Đã khám</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Appointment</button>
        </form>
        <a href="index.php?controller=Appointment" class="btn btn-primary">Back</a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>

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
<script>
document.querySelectorAll('.send-appointment-notify-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('notifyAppointmentId').value = this.dataset.id;
        document.getElementById('notifyAppointmentTime').value = this.dataset.startTime;
        document.getElementById('notifyAppointmentRoom').value = this.dataset.room;
        document.getElementById('notifyAppointmentDoctor').value = this.dataset.doctor;
        // Reset form
        document.querySelector('#appointmentNotifyForm [name="to"]').value = '';
        document.querySelector('#appointmentNotifyForm [name="patientName"]').value = '';
        document.getElementById('appointmentNotifyResult').textContent = '';
        var modal = new bootstrap.Modal(document.getElementById('appointmentNotifyModal'));
        modal.show();
    });
});

document.getElementById('appointmentNotifyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    document.getElementById('appointmentNotifyResult').textContent = 'Đang gửi...';
    try {
        const response = await fetch('index.php?controller=Appointment&action=sendAppointmentNotification', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if(result.success) {
            document.getElementById('appointmentNotifyResult').textContent = result.message;
        } else {
            document.getElementById('appointmentNotifyResult').textContent = 'Lỗi: ' + (result.error || 'Không gửi được thông báo');
        }
    } catch (err) {
        document.getElementById('appointmentNotifyResult').textContent = 'Lỗi kết nối tới Notification Service!';
    }
});
</script>
</body>
</html>