<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <h1>
    Hospital Management Homepage
</h1>

<?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
        <a href="index.php?controller=Prescription&action=index" class="btn btn-primary">Prescription Service</a>
<?php endif; ?>

<?php if (in_array($_SESSION['role'], ['admin', 'staff'])): ?>
        <a href="index.php?controller=Doctor&action=index" class="btn btn-primary">Doctor Service</a>
<?php endif; ?>

<?php if (in_array($_SESSION['role'], ['admin', 'staff', 'doctor'])): ?>
        <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-primary">Medicine Service</a>
<?php endif; ?>

<?php if (in_array($_SESSION['role'], ['admin', 'staff'])): ?>
        <a href="index.php?controller=Appointment&action=index" class="btn btn-primary">Appointment Service</a>
        <a href="index.php?controller=Notification&action=index" class="btn btn-success">Notification Management</a>
        <a href="index.php?controller=Report&action=dashboard" class="btn btn-primary">Report Management</a>
<?php endif; ?>
<a href="index.php?controller=Auth&action=logout" class="btn btn-primary">Logout</a>
</body>
</html>