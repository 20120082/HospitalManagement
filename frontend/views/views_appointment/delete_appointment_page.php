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
        <h2>Delete Appointment</h2>
        <form action="index.php?controller=Appointment&action=delete" method="POST">
            <div class="mb-3">
                <label for="appointmentId" class="form-label">Select Appointment to Delete</label>
                <select class="form-select" id="appointmentId" name="appointmentId" required>
                    <?php foreach ($appointments as $appointment): ?>
                        <option value="<?php echo $appointment['id']; ?>">
                            ID: <?php echo $appointment['id']; ?> - Patient: <?php echo $appointment['idPatient']; ?> - Doctor:
                            <?php foreach ($doctors as $doctor): ?>
                                <?php if ($doctor['id'] == $appointment['idDoctor']): ?>
                                <?php echo htmlspecialchars($doctor['name']); ?>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>- Room: <?php echo $appointment['idRoom']; ?> - Time: <?php echo $appointment['startTime']; ?> - Status: <?php echo $appointment['status']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Delete Appointment</button>
        </form>
        <a href="index.php?controller=Appointment" class="btn btn-primary">Back</a>
    </div>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>