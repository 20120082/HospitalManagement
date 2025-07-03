<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Delete Medicine</h2>
        <?php if (!$medicine): ?>
            <div class="alert alert-danger">Medicine not found.</div>
        <?php else: ?>
            <form method="post" action="index.php?controller=Medicine&action=delete">
                <input type="hidden" name="id" value="<?= htmlspecialchars($medicine->id) ?>">
                <p>Are you sure you want to delete medicine <strong><?= htmlspecialchars($medicine->name) ?></strong> (Code: <?= htmlspecialchars($medicine->code) ?>)?</p>
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
