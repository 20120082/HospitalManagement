<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Delete Doctor</h2>
        <form action="index.php?controller=Doctor&action=delete" method="POST">
            <div class="mb-3">
                <label for="doctorId" class="form-label">Select Doctor to Delete</label>
                <select class="form-select" id="doctorId" name="doctorId" required>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?php echo $doctor['id']; ?>">
                            ID: <?php echo $doctor['id']; ?> - Name: <?php echo $doctor['name']; ?>- Gender: <?php echo $doctor['gender']; ?>- Phone: <?php echo $doctor['phoneNumber']; ?> - Position: <?php echo $doctor['position'] ?? 'N/A'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Delete Doctor</button>
        </form>
        <a href="index.php?controller=Doctor" class="btn btn-secondary mt-3">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  