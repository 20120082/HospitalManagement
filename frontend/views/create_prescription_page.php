<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Prescription</h2>
        <form id="createPrescriptionForm" action="index.php?controller=Prescription&action=create" method="POST">
            <div class="mb-3">
                <label for="idPatient" class="form-label">Patient ID</label>
                <input type="number" class="form-control" id="idPatient" name="idPatient" required>
            </div>
            <div class="mb-3">
                <label for="createdDate" class="form-label">Created Date</label>
                <input type="date" class="form-control" id="createdDate" name="createdDate" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Chưa lấy">Chưa lấy</option>
                    <option value="Đã lấy">Đã lấy</option>
                </select>
            </div>
            <h4>Prescription Details</h4>
            <table class="table table-bordered" id="medicineTable">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="medicineRows">
                    <tr class="medicine-row">
                        <td>
                            <select class="form-select medicine-id" name="idMedicine[0]" required>
                                <option value="">Select a medicine</option>
                                <?php
                                foreach ($medicines as $medicine) {
                                    echo "<option value='{$medicine['id']}' data-unit='{$medicine['unit']}' data-price='{$medicine['price']}'>{$medicine['name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="number" step="1" min="1" class="form-control quantity" name="quantity[0]" required></td>
                        <td><input type="text" class="form-control unit" name="unit[0]" readonly></td>
                        <td><input type="number" step="0.01" class="form-control price" name="price[0]" readonly></td>
                        <td><button type="button" class="btn btn-danger remove-medicine">Remove</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="addMedicine">Add More Medicine</button>
            <button type="submit" class="btn btn-success">Create Prescription</button>
        </form>
        <a href="index.php?controller=Prescription" class="btn btn-secondary mt-3">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let rowCount = 1;

        function addMedicine() {
            const tbody = document.getElementById('medicineRows');
            const newRow = document.createElement('tr');
            newRow.className = 'medicine-row';
            newRow.innerHTML = `
                <td>
                    <select class="form-select medicine-id" name="idMedicine[${rowCount}]" required>
                        <option value="">Select a medicine</option>
                        <?php
                        foreach ($medicines as $medicine) {
                            echo "<option value='{$medicine['id']}' data-unit='{$medicine['unit']}' data-price='{$medicine['price']}'>{$medicine['name']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="number" step="1" min="1" class="form-control quantity" name="quantity[${rowCount}]" required></td>
                <td><input type="text" class="form-control unit" name="unit[${rowCount}]" readonly></td>
                <td><input type="number" step="0.01" class="form-control price" name="price[${rowCount}]" readonly></td>
                <td><button type="button" class="btn btn-danger remove-medicine">Remove</button></td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
            attachEventListeners();
        }

        function removeMedicine(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowIndices();
        }

        function attachEventListeners() {
            document.querySelectorAll('.medicine-id').forEach(select => {
                select.removeEventListener('change', updateFields);
                select.addEventListener('change', updateFields);
            });

            document.querySelectorAll('.remove-medicine').forEach(button => {
                button.removeEventListener('click', () => removeMedicine(button));
                button.addEventListener('click', () => removeMedicine(button));
            });
        }

        function updateFields() {
            const row = this.closest('tr');
            const unitInput = row.querySelector('.unit');
            const priceInput = row.querySelector('.price');
            const selectedOption = this.options[this.selectedIndex];
            unitInput.value = selectedOption.getAttribute('data-unit') || '';
            priceInput.value = selectedOption.getAttribute('data-price') || '';
        }

        function updateRowIndices() {
            const rows = document.querySelectorAll('.medicine-row');
            rows.forEach((row, index) => {
                row.querySelector('.medicine-id').name = `idMedicine[${index}]`;
                row.querySelector('.quantity').name = `quantity[${index}]`;
                row.querySelector('.unit').name = `unit[${index}]`;
                row.querySelector('.price').name = `price[${index}]`;
            });
            rowCount = rows.length;
        }

        document.getElementById('addMedicine').addEventListener('click', addMedicine);
        attachEventListeners();
    </script>
</body>
</html>