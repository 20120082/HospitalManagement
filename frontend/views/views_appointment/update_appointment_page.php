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
        <h2>Update Appointment</h2>
        <form action="index.php?controller=Appointment&action=update" method="POST" class="mb-5">
            <div class="mb-3">
                <label for="appointmentId" class="form-label">Select Appointment</label>
                <select class="form-select" id="appointmentId" name="appointmentId" required>
                    <?php foreach ($appointments as $appointment): ?>
                        <option value="<?php echo $appointment['id']; ?>">
                            ID: <?php echo $appointment['id']; ?> - Patient: <?php echo $appointment['idPatient']; ?> - Doctor: 
                            <?php foreach ($doctors as $doctor): ?>
                                <?php if ($doctor['id'] == $appointment['idDoctor']): ?>
                                <?php echo htmlspecialchars($doctor['name']); ?>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            - Room: <?php echo $appointment['idRoom']; ?> - Time: <?php echo $appointment['startTime']; ?> - Status: <?php echo $appointment['status']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
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
            <button type="submit" class="btn btn-primary">Update Appointment</button>
        </form>
        <a href="index.php?controller=Appointment" class="btn btn-primary">Back</a>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>