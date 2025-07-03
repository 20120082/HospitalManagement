<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Medicine Result</h2>
        <?php if ($result): ?>
            <div class="alert alert-success">Medicine added successfully!</div>
        <?php else: ?>
            <div class="alert alert-danger">Failed to add medicine.</div>
        <?php endif; ?>
        <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-primary">Back to List</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
