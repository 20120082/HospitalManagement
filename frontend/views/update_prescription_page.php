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
    <h2>Update Prescription Status</h2>
        <form action="index.php?controller=Prescription&action=updateStatus" method="POST">
            <div class="mb-3">
                <label for="prescriptionId" class="form-label">Select Prescription</label>
                <select class="form-select" id="prescriptionId" name="prescriptionId" required>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <option value="<?php echo $prescription['id']; ?>">
                            ID: <?php echo $prescription['id']; ?> - Patient: 
                            <?php foreach ($patients as $patient): ?>
                                <?php if ($patient['patientId'] == $prescription['idPatient']): ?>
                                <?php echo htmlspecialchars($patient['fullName']); ?> - <?php echo $prescription['idPatient']; ?>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?> - Date: <?php echo $prescription['createdDate']; ?> - Status: <?php echo $prescription['status']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">New Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Chưa lấy">Chưa lấy</option>
                    <option value="Đã lấy">Đã lấy</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <a href="index.php?controller=Prescription" class="btn btn-primary">Back</a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>