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
                    <th>Patient ID</th>
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
                            <td><?php echo htmlspecialchars($prescription['idPatient']); ?></td>
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
</body>
    
        