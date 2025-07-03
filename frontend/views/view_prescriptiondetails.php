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
        <a href="index.php?controller=Prescription&action=ListPage" class="btn btn-primary">Back</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>