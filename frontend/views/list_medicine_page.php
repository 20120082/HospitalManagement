<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container-fluid mt-5" style="max-width: 98vw;">
        <h2>Medicine List</h2>
        <form class="row g-3 mb-3" method="get" action="index.php" id="medicine-search-form" autocomplete="off">
            <input type="hidden" name="controller" value="Medicine">
            <input type="hidden" name="action" value="ListPage">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search_name" id="search_name" placeholder="Search by name" value="<?= isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="search_code" id="search_code" placeholder="Search by code" value="<?= isset($_GET['search_code']) ? htmlspecialchars($_GET['search_code']) : '' ?>">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="search_category" id="search_category">
                    <option value="">All categories</option>
                    <?php if (!empty($all_categories)):
                        foreach ($all_categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>" <?= (isset($_GET['search_category']) && $_GET['search_category'] == $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </form>
        <a href="index.php?controller=Medicine&action=CreatePage" class="btn btn-success mb-3">Add Medicine</a>
        <div style="overflow-x: auto;">
        <table class="table table-bordered mb-5" style="min-width: 1200px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Manufacturer</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($medicines)): ?>
                    <tr>
                        <td colspan="10" class="text-center">No medicines found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td><?= htmlspecialchars($medicine->id) ?></td>
                            <td><?= htmlspecialchars($medicine->code) ?></td>
                            <td><?= htmlspecialchars($medicine->name) ?></td>
                            <td><?= htmlspecialchars($medicine->category) ?></td>
                            <td><?= htmlspecialchars($medicine->description) ?></td>
                            <td><?= htmlspecialchars($medicine->unit) ?></td>
                            <td><?= htmlspecialchars($medicine->price) ?></td>
                            <td><?= htmlspecialchars($medicine->quantity) ?></td>
                            <td><?= htmlspecialchars($medicine->manufacturer) ?></td>
                            <td><?= htmlspecialchars($medicine->expiryDate) ?></td>
                            <td>
                                <a href="index.php?controller=Medicine&action=UpdatePage&id=<?= $medicine->id ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="index.php?controller=Medicine&action=DeletePage&id=<?= $medicine->id ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // AJAX search, không reload trang khi tìm kiếm
    const form = document.getElementById('medicine-search-form');
    let typingTimer;
    const doneTypingInterval = 0; // ms, gửi request ngay khi nhập
    const tableBody = document.querySelector('table tbody');

    function fetchMedicines() {
        const params = new URLSearchParams(new FormData(form)).toString();
        fetch('index.php?' + params + '&ajax=1')
            .then(res => res.text())
            .then(html => {
                tableBody.innerHTML = html;
            });
    }

    document.getElementById('search_name').addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(fetchMedicines, doneTypingInterval);
    });
    document.getElementById('search_code').addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(fetchMedicines, doneTypingInterval);
    });
    document.getElementById('search_category').addEventListener('change', function() {
        fetchMedicines();
    });
    </script>
</body>
</html>
